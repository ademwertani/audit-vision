<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('youtube_videos', function (Blueprint $table) {
            $table->bigIncrements('id');           // PK auto-incrément
            $table->string('url');                 // URL obligatoire
            $table->string('title')->nullable();   // Titre optionnel
            $table->text('description')->nullable(); // Description optionnelle
            $table->timestamps();                  // created_at / updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('youtube_videos');
    }
};
