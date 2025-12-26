<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add auto-approve setting for wishes
     */
    public function up(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->boolean('is_auto_approve_wishes')->default(false)->after('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropColumn('is_auto_approve_wishes');
        });
    }
};
