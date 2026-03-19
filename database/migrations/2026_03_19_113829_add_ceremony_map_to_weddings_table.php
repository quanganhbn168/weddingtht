<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->string('groom_ceremony_map_url')->nullable()->after('groom_address');
            $table->text('groom_ceremony_map_embed')->nullable()->after('groom_ceremony_map_url');
            $table->string('bride_ceremony_map_url')->nullable()->after('bride_address');
            $table->text('bride_ceremony_map_embed')->nullable()->after('bride_ceremony_map_url');
        });
    }

    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropColumn([
                'groom_ceremony_map_url',
                'groom_ceremony_map_embed',
                'bride_ceremony_map_url',
                'bride_ceremony_map_embed',
            ]);
        });
    }
};
