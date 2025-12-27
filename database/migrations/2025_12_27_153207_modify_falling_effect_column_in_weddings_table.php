<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            // Change Enum to String to allow flexible values (like shooting_stars)
            // Note: DB::statement used for guaranteed ENUM -> VARCHAR conversion in MySQL
            // because strict mode or doctrine can sometimes struggle with existing Enums
        });

        DB::statement("ALTER TABLE weddings MODIFY COLUMN falling_effect VARCHAR(255) DEFAULT 'hearts'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to Enum if needed (be careful of truncated data if this runs)
        // For safety, we keep it as string in down() or defining the strict enum again
         DB::statement("ALTER TABLE weddings MODIFY COLUMN falling_effect ENUM('hearts', 'petals', 'snow', 'leaves', 'stars', 'none') DEFAULT 'hearts'");
    }
};
