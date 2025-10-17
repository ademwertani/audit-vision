<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // 1) Add new FK
            if (!Schema::hasColumn('projects', 'service_id')) {
                $table->foreignId('service_id')
                    ->nullable() // set nullable if you plan to backfill gradually
                    ->constrained('services')
                    ->cascadeOnDelete()
                    ->after('image');
            }
        });

        // 2) OPTIONAL quick copy: only if old IDs match service IDs
        if (Schema::hasColumn('projects', 'category_id') && Schema::hasColumn('projects', 'service_id')) {
            DB::statement('UPDATE projects SET service_id = category_id WHERE service_id IS NULL');
        }

        // 3) Drop old FK & column if present
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'category_id')) {
                // Try to drop FK if it exists (name may vary)
                try { $table->dropForeign(['category_id']); } catch (\Throwable $e) {}
                try { $table->dropIndex(['category_id']); } catch (\Throwable $e) {}
                $table->dropColumn('category_id');
            }
        });

        // 4) Make service_id NOT NULL once data is clean
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('service_id')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Recreate category_id (no FK target assumed)
            $table->unsignedBigInteger('category_id')->nullable()->after('image');
        });

        // Best-effort rollback copy
        if (Schema::hasColumn('projects', 'service_id') && Schema::hasColumn('projects', 'category_id')) {
            DB::statement('UPDATE projects SET category_id = service_id WHERE category_id IS NULL');
        }

        Schema::table('projects', function (Blueprint $table) {
            try { $table->dropForeign(['service_id']); } catch (\Throwable $e) {}
            try { $table->dropIndex(['service_id']); } catch (\Throwable $e) {}
            $table->dropColumn('service_id');
        });
    }
};
