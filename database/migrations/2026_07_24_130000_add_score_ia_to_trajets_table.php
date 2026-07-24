<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trajets', function (Blueprint $table) {
            $table->json('score_ia')->nullable()->after('jours_recurrence')
                  ->comment('Stockage Cast du résultat IA: score, justification, horaire_suggere');
        });
    }

    public function down(): void
    {
        Schema::table('trajets', function (Blueprint $table) {
            $table->dropColumn('score_ia');
        });
    }
};
