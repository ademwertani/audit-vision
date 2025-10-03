<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('label');                     // ex: Homes, Companies, Farms
            $table->string('slug')->unique();            // ex: homes, companies, farms
            $table->unsignedInteger('value')->default(0);
            $table->boolean('is_accent')->default(false);// pour mettre la carte en accent si tu veux
            $table->smallInteger('display_order')->default(0)->index(); // ordre d’affichage
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
