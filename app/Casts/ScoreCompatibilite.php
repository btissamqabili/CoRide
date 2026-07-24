<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Cast Eloquent pour le résultat du score IA.
 *
 * Structure attendue :
 * {
 *   "score": int (0-100),
 *   "justification": string,
 *   "horaire_suggere": string
 * }
 *
 * Utilisation dans le modèle Trajet :
 *   protected function casts(): array {
 *       return ['score_ia' => ScoreCompatibilite::class];
 *   }
 */
class ScoreCompatibilite implements CastsAttributes
{
    /**
     * Désérialise la valeur JSON de la base vers un tableau PHP.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?array
    {
        if (is_null($value)) {
            return null;
        }

        $decoded = json_decode($value, true);

        if (!is_array($decoded)) {
            return null;
        }

        return [
            'score'           => (int) ($decoded['score'] ?? 0),
            'justification'   => (string) ($decoded['justification'] ?? ''),
            'horaire_suggere' => (string) ($decoded['horaire_suggere'] ?? ''),
        ];
    }

    /**
     * Sérialise le tableau PHP en JSON pour le stockage.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string|null
    {
        if (is_null($value)) {
            return null;
        }

        if (!is_array($value)) {
            throw new InvalidArgumentException(
                'Le Cast ScoreCompatibilite attend un tableau avec les clés: score, justification, horaire_suggere.'
            );
        }

        // Validation de la structure
        $validated = [
            'score'           => max(0, min(100, (int) ($value['score'] ?? 0))),
            'justification'   => (string) ($value['justification'] ?? ''),
            'horaire_suggere' => (string) ($value['horaire_suggere'] ?? ''),
        ];

        return json_encode($validated, JSON_UNESCAPED_UNICODE);
    }
}
