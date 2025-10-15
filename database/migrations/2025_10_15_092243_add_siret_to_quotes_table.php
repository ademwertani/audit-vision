<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            // Colonne SIRET : 14 caractères, nullable pour compatibilité avec les données existantes
            $table->char('siret', 14)->nullable()->after('telephone')->index();
        });

        // (Optionnel) Contrainte CHECK si votre SGBD la supporte (MySQL 8.0.16+ / PostgreSQL)
        // Décommentez si vous voulez bloquer au niveau BDD toute valeur non composée de 14 chiffres.
        /*
        DB::statement("
            ALTER TABLE quotes
            ADD CONSTRAINT chk_quotes_siret
            CHECK (siret REGEXP '^[0-9]{14}$' OR siret IS NULL)
        ");
        */
    }

    public function down(): void
    {
        // Supprimer d'abord la contrainte si vous l'avez ajoutée
        // (MySQL) :
        // DB::statement('ALTER TABLE quotes DROP CONSTRAINT chk_quotes_siret');
        // (MariaDB) :
        // DB::statement('ALTER TABLE quotes DROP CHECK chk_quotes_siret');

        Schema::table('quotes', function (Blueprint $table) {
            $table->dropIndex(['siret']);
            $table->dropColumn('siret');
        });
    }
};
