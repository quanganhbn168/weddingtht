<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->string('groom_ceremony_venue')->nullable()->after('groom_ceremony_time');
            $table->string('bride_ceremony_venue')->nullable()->after('bride_ceremony_time');
        });
    }

    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropColumn([
                'groom_ceremony_venue',
                'bride_ceremony_venue',
            ]);
        });
    }
};
