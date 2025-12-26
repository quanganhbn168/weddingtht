<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add tier to templates table
     */
    public function up(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->enum('tier', ['basic', 'pro'])->default('basic')->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn('tier');
        });
    }
};
