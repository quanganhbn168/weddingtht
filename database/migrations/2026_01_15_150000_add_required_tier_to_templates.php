<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add required_tier field to templates for access control.
     * Templates can be basic, standard, or pro.
     */
    public function up(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->enum('required_tier', ['basic', 'standard', 'pro'])
                ->default('basic')
                ->after('type');
        });

        // Update weddings tier to include basic
        Schema::table('weddings', function (Blueprint $table) {
            // Modify tier to include 'basic'
            $table->string('tier', 20)->default('standard')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn('required_tier');
        });
    }
};
