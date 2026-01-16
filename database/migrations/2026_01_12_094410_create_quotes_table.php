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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();

            // 👇 أهم حقل حسب الخطأ: nom_beneficiaire
            $table->string('nom_beneficiaire');

            // 👇 باقي الحقول تقديرية / كلاسيكية لطلب devis
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('type_bien')->nullable();     // appartement / maison / local, etc.
            $table->string('ville')->nullable();
            $table->string('code_postal')->nullable();
            $table->integer('surface')->nullable();      // surface en m²
            $table->text('message')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
