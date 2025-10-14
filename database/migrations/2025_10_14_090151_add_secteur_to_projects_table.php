<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Ajoute la colonne après "description"
            $table->string('secteur', 32)
                  ->nullable()
                  ->after('description')
                  ->index(); // utile pour filtrer par secteur
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['secteur']);
            $table->dropColumn('secteur');
        });
    }
};
