<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('trajet_id')
                  ->constrained('trajets')
                  ->cascadeOnDelete();

            $table->foreignId('passager_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->enum('statut', [
                'en_attente',
                'confirmee',
                'refusee',
                'annulee'
            ]);

            $table->dateTime('date_reservation');

            // Un employé ne peut réserver qu'une seule fois le même trajet
            $table->unique(['trajet_id', 'passager_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};