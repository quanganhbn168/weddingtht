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
        Schema::table('weddings', function (Blueprint $table) {
            if (!Schema::hasColumn('weddings', 'type')) {
                $table->string('type')->default('wedding')->after('slug');
            }
            if (!Schema::hasColumn('weddings', 'template_id')) {
                $table->foreignId('template_id')->nullable()->after('type')->constrained('templates')->onDelete('set null');
            }
            if (!Schema::hasColumn('weddings', 'content')) {
                $table->json('content')->nullable()->after('template_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            //
        });
    }
};
