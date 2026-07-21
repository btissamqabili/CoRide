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
        Schema::table('users', function (Blueprint $table) {

            $table->string('ville_residence')->after('email');

            $table->enum('role', [
                'conducteur',
                'passager',
                'les_deux'
            ])->after('ville_residence');

            $table->foreignId('entreprise_id')
                  ->after('role')
                  ->constrained('entreprises')
                  ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['entreprise_id']);

            $table->dropColumn([
                'ville_residence',
                'role',
                'entreprise_id'
            ]);

        });
    }
};