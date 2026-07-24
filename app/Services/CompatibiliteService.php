<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Trajet;
use App\Models\User;
use Prism\Prism\Facades\Prism;
use Throwable;

/**
 * Service de scoring de compatibilité trajet/passager.
 */
class CompatibiliteService
{
    private static array $zones = [
        'lyon'      => ['Lyon', 'Villeurbanne', 'Bron', 'Vénissieux', 'Décines', 'Caluire', 'Saint-Priest', 'Meyzieu', 'Rillieux'],
        'grenoble'  => ['Grenoble', 'Échirolles', 'Meylan', 'Crolles', 'Voreppe', 'Vizille', 'Pontcharra', 'Saint-Martin-d\'Hères'],
        'bordeaux'  => ['Bordeaux', 'Mérignac', 'Pessac', 'Talence', 'Lormont', 'Bègles'],
        'nantes'    => ['Nantes', 'Saint-Herblain', 'Rezé', 'Orvault', 'Bouguenais', 'Carquefou', 'Saint-Sébastien'],
        'marseille' => ['Marseille', 'Aix-en-Provence', 'Aubagne', 'Vitrolles', 'Martigues', 'Gardanne'],
    ];

    /**
     * Calcule le score de compatibilité entre un trajet et un passager.
     */
    public function calculer(Trajet $trajet, User $passager): array
    {
        $score  = 0;
        $points = [];

        // 1. Zone géographique
        $zonePassager = $this->trouverZone($passager->ville_residence);
        $zoneDepart   = $this->trouverZone($trajet->ville_depart);

        if ($zonePassager && $zoneDepart && $zonePassager === $zoneDepart) {
            $score += 40;
            $points[] = "✓ Même zone géographique ({$zoneDepart}) : le départ de {$trajet->ville_depart} est proche de votre domicile à {$passager->ville_residence}";
        } elseif ($passager->ville_residence === $trajet->ville_depart) {
            $score += 40;
            $points[] = "✓ Départ exactement depuis votre ville ({$passager->ville_residence})";
        } else {
            $score += 10;
            $points[] = "⚠ Ville de départ ({$trajet->ville_depart}) éloignée de votre domicile ({$passager->ville_residence})";
        }

        // 2. Entreprise commune
        if ($trajet->conducteur && $trajet->conducteur->entreprise_id === $passager->entreprise_id) {
            $score += 15;
            $nomEnt = $trajet->conducteur->entreprise->nom ?? 'votre entreprise';
            $points[] = "✓ Même entreprise ({$nomEnt}) : covoiturage entre collègues directs";
        } else {
            $nomCondEnt = $trajet->conducteur->entreprise->nom ?? 'Entreprise externe';
            $nomPassEnt = $passager->entreprise->nom ?? 'votre entreprise';
            $points[] = "ℹ Entreprises différentes ({$nomCondEnt} / {$nomPassEnt}) — covoiturage inter-entreprises";
        }

        // 3. Plages horaires
        $heure = (int) date('H', strtotime($trajet->horaire));
        if ($heure >= 7 && $heure <= 9) {
            $score += 25;
            $points[] = "✓ Horaire matinal idéal ({$heure}h00) correspondant aux heures de pointe";
        } elseif ($heure >= 6 && $heure <= 10) {
            $score += 15;
            $points[] = "~ Horaire acceptable ({$heure}h00)";
        } else {
            $score += 5;
            $points[] = "⚠ Horaire atypique ({$heure}h00)";
        }

        // 4. Places disponibles
        $placesRestantes = $trajet->placesRestantes();
        if ($placesRestantes >= 2) {
            $score += 10;
            $points[] = "✓ {$placesRestantes} places encore disponibles";
        } elseif ($placesRestantes === 1) {
            $score += 5;
            $points[] = "⚠ Dernière place disponible";
        } else {
            $points[] = "✗ Trajet complet";
        }

        // 5. Récurrence
        if ($trajet->jours_recurrence) {
            $joursCount = count(array_filter(explode(',', $trajet->jours_recurrence)));
            if ($joursCount >= 4) {
                $score += 10;
                $points[] = "✓ Trajet récurrent ({$joursCount}j/semaine)";
            } else {
                $score += 5;
                $points[] = "~ Trajet récurrent ({$joursCount}j/semaine)";
            }
        } else {
            $points[] = "ℹ Trajet ponctuel";
        }

        $horaireSuggere = date('H:i', strtotime($trajet->horaire));
        $justification  = implode("\n", $points);

        return [
            'score'           => min(100, $score),
            'justification'   => $justification,
            'horaire_suggere' => "Départ suggéré à " . $horaireSuggere,
        ];
    }

    /**
     * Génère la compatibilité pour une réservation (avec Prism ou fallback).
     */
    public function generate(Reservation $reservation): array
    {
        try {
            $prompt = "
Tu es un assistant de covoiturage.
Retourne uniquement un JSON.
Passager : Nom: {$reservation->passager->name}, Ville: {$reservation->passager->ville_residence}
Conducteur : Nom: {$reservation->trajet->conducteur->name}, Départ: {$reservation->trajet->ville_depart}, Arrivée: {$reservation->trajet->ville_arrivee}, Horaire: {$reservation->trajet->horaire}

Format JSON attendu :
{
    \"score\": 90,
    \"justification\": \"...\",
    \"horaire_suggere\": \"08:15\"
}
";
            $response = Prism::text()
                ->using('openai', 'gpt-4.1-mini')
                ->withPrompt($prompt)
                ->asText();

            $decoded = json_decode($response, true);
            if (is_array($decoded) && isset($decoded['score'])) {
                return $decoded;
            }
        } catch (Throwable $e) {
            // Fallback si la clé API Prism / OpenAI n'est pas configurée
        }

        return $this->calculer($reservation->trajet, $reservation->passager);
    }

    private function trouverZone(string $ville): ?string
    {
        foreach (self::$zones as $zone => $villes) {
            if (in_array($ville, $villes, true)) {
                return $zone;
            }
        }
        return null;
    }
}