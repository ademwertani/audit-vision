<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');   // nom du partenaire
            $table->string('logo');   // chemin du fichier (storage/app/public/partners/...)
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('partners');
    }
};
