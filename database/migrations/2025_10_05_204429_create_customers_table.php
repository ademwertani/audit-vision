<?php

// database/migrations/2025_01_01_000000_create_customers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('client_name', 120);
            $table->string('title', 150);
            $table->text('comment')->nullable();
            $table->unsignedTinyInteger('note'); // 0..5
            $table->timestamps();
        });

        // Optionnel: contrainte CHECK (MySQL 8+)
        try {
            DB::statement('ALTER TABLE customers ADD CONSTRAINT chk_customers_note CHECK (note BETWEEN 0 AND 5)');
        } catch (\Throwable $e) {
            // ignore si non supporté
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
