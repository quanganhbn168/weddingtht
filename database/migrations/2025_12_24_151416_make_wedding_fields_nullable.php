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
            $table->string('groom_name')->nullable()->change();
            $table->string('bride_name')->nullable()->change();
            $table->string('groom_father')->nullable()->change();
            $table->string('groom_mother')->nullable()->change();
            $table->string('bride_father')->nullable()->change();
            $table->string('bride_mother')->nullable()->change();
            $table->date('event_date')->nullable()->change();
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
