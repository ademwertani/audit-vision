<?php

// database/migrations/2025_10_01_000000_update_quotes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            // Renommer "nom" -> "nom_beneficiaire"
            if (Schema::hasColumn('quotes', 'nom')) {
                $table->renameColumn('nom', 'nom_beneficiaire');
            } else {
                $table->string('nom_beneficiaire')->after('id');
            }

            // Ajouter les nouveaux champs
            if (!Schema::hasColumn('quotes', 'prenom_beneficiaire')) {
                $table->string('prenom_beneficiaire')->nullable()->after('nom_beneficiaire');
            }

            // "email" existe déjà dans ton modèle, on s'assure de sa présence
            if (!Schema::hasColumn('quotes', 'email')) {
                $table->string('email')->nullable()->after('prenom_beneficiaire');
            } else {
                $table->string('email')->nullable()->change();
            }

            if (!Schema::hasColumn('quotes', 'telephone')) {
                $table->string('telephone', 30)->nullable()->after('email');
            }

            if (!Schema::hasColumn('quotes', 'raison_sociale')) {
                $table->string('raison_sociale')->nullable()->after('telephone');
            }

            // "adresse" existe déjà → on le laisse, sinon on le crée
            if (!Schema::hasColumn('quotes', 'adresse')) {
                $table->string('adresse')->nullable()->after('raison_sociale');
            } else {
                $table->string('adresse')->nullable()->change();
            }

            if (!Schema::hasColumn('quotes', 'secteur')) {
                // Enum logique (valeur texte contrôlée via validation)
                $table->string('secteur', 20)->after('adresse');
            }

            if (!Schema::hasColumn('quotes', 'operations')) {
                // Liste d’opérations choisies (JSON array)
                $table->json('operations')->nullable()->after('secteur');
            }
        });
    }

    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            // Revenir en arrière (attention si des données existent)
            if (Schema::hasColumn('quotes', 'nom_beneficiaire')) {
                $table->renameColumn('nom_beneficiaire', 'nom');
            }
            if (Schema::hasColumn('quotes', 'prenom_beneficiaire')) {
                $table->dropColumn('prenom_beneficiaire');
            }
            if (Schema::hasColumn('quotes', 'telephone')) {
                $table->dropColumn('telephone');
            }
            if (Schema::hasColumn('quotes', 'raison_sociale')) {
                $table->dropColumn('raison_sociale');
            }
            if (Schema::hasColumn('quotes', 'secteur')) {
                $table->dropColumn('secteur');
            }
            if (Schema::hasColumn('quotes', 'operations')) {
                $table->dropColumn('operations');
            }
        });
    }
};
