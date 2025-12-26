<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add Pro features to weddings table:
     * - tier: standard/pro
     * - is_demo: demo vs customer
     * - falling_effect: hearts/petals/snow/leaves/stars/none
     * - show_preload: 囍 sliding door animation
     * - custom_domain: Pro custom domain
     * - expires_at: Standard 1 year, Pro null (forever)
     */
    public function up(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->enum('tier', ['standard', 'pro'])->default('standard')->after('is_active');
            $table->boolean('is_demo')->default(false)->after('tier');
            $table->enum('falling_effect', ['hearts', 'petals', 'snow', 'leaves', 'stars', 'none'])->default('hearts')->after('is_demo');
            $table->boolean('show_preload')->default(false)->after('falling_effect');
            $table->string('custom_domain')->nullable()->after('show_preload');
            $table->date('expires_at')->nullable()->after('custom_domain');
        });
    }

    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropColumn(['tier', 'is_demo', 'falling_effect', 'show_preload', 'custom_domain', 'expires_at']);
        });
    }
};
