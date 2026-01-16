<?php

// create_certificats_table.php (Migration)
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatsTable extends Migration
{
    public function up()
    {
        Schema::create('certificats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('image')->nullable();   // chemin vers l'image
            $table->string('pdf_file');             // fichier PDF
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificats');
    }
}
