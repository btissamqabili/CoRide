<?php

namespace Tests\Feature;

use App\Casts\ScoreCompatibilite;
use App\Models\Entreprise;
use App\Models\Reservation;
use App\Models\Trajet;
use App\Models\User;
use App\Services\CompatibiliteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoRideTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeding_creates_expected_data()
    {
        $this->seed();

        $this->assertEquals(5, Entreprise::count());
        $this->assertEquals(40, User::count());
        $this->assertEquals(25, Trajet::count());
        $this->assertGreaterThanOrEqual(30, Reservation::count());
    }

    public function test_passager_can_store_reservation_without_explicit_statut_and_date()
    {
        $entreprise = Entreprise::factory()->create();
        $conducteur = User::factory()->create(['entreprise_id' => $entreprise->id, 'role' => 'conducteur']);
        $passager   = User::factory()->create(['entreprise_id' => $entreprise->id, 'role' => 'passager']);

        $trajet = Trajet::create([
            'conducteur_id'      => $conducteur->id,
            'ville_depart'       => 'Caluire',
            'ville_arrivee'      => 'Lyon',
            'horaire'            => '2026-08-05 08:15:00',
            'places_disponibles' => 3,
        ]);

        $response = $this->actingAs($passager)->post(route('reservations.store'), [
            'trajet_id' => $trajet->id,
        ]);

        $response->assertRedirect(route('reservations.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('reservations', [
            'trajet_id'   => $trajet->id,
            'passager_id' => $passager->id,
            'statut'      => 'en_attente',
        ]);
    }

    public function test_compatibilite_service_calculates_score_and_justification()
    {
        $entreprise = Entreprise::factory()->create(['nom' => 'MobiliTech']);

        $conducteur = User::factory()->create([
            'entreprise_id'   => $entreprise->id,
            'ville_residence' => 'Lyon',
            'role'            => 'conducteur',
        ]);

        $passager = User::factory()->create([
            'entreprise_id'   => $entreprise->id,
            'ville_residence' => 'Lyon',
            'role'            => 'passager',
        ]);

        $trajet = Trajet::create([
            'conducteur_id'      => $conducteur->id,
            'ville_depart'       => 'Lyon',
            'ville_arrivee'      => 'Villeurbanne',
            'horaire'            => '2026-08-04 08:00:00',
            'places_disponibles' => 3,
            'jours_recurrence'   => 'Lundi, Mercredi, Vendredi',
        ]);

        $service = new CompatibiliteService();
        $result = $service->calculer($trajet, $passager);

        $this->assertIsArray($result);
        $this->assertGreaterThanOrEqual(70, $result['score']);
        $this->assertStringContainsString('Même zone géographique', $result['justification']);
        $this->assertStringContainsString('Même entreprise', $result['justification']);
    }

    public function test_score_compatibilite_cast_serializes_and_deserializes_correctly()
    {
        $entreprise = Entreprise::factory()->create();
        $conducteur = User::factory()->create(['entreprise_id' => $entreprise->id]);

        $trajet = Trajet::create([
            'conducteur_id'      => $conducteur->id,
            'ville_depart'       => 'Lyon',
            'ville_arrivee'      => 'Bron',
            'horaire'            => '2026-08-04 08:00:00',
            'places_disponibles' => 2,
            'score_ia'           => [
                'score'           => 85,
                'justification'   => 'Compatibilité optimale',
                'horaire_suggere' => 'Départ à 08:00',
            ],
        ]);

        $trajet = $trajet->fresh();

        $this->assertIsArray($trajet->score_ia);
        $this->assertEquals(85, $trajet->score_ia['score']);
        $this->assertEquals('Compatibilité optimale', $trajet->score_ia['justification']);
        $this->assertEquals('Départ à 08:00', $trajet->score_ia['horaire_suggere']);
    }

    public function test_cannot_delete_trajet_with_confirmed_reservations()
    {
        $entreprise = Entreprise::factory()->create();
        $conducteur = User::factory()->create(['entreprise_id' => $entreprise->id, 'role' => 'conducteur']);
        $passager   = User::factory()->create(['entreprise_id' => $entreprise->id, 'role' => 'passager']);

        $trajet = Trajet::create([
            'conducteur_id'      => $conducteur->id,
            'ville_depart'       => 'Grenoble',
            'ville_arrivee'      => 'Meylan',
            'horaire'            => '2026-08-04 08:00:00',
            'places_disponibles' => 2,
        ]);

        Reservation::create([
            'trajet_id'        => $trajet->id,
            'passager_id'      => $passager->id,
            'statut'           => 'confirmee',
            'date_reservation' => now(),
        ]);

        $response = $this->actingAs($conducteur)->delete(route('trajets.destroy', $trajet));

        $response->assertRedirect(route('trajets.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('trajets', ['id' => $trajet->id]);
    }
}
