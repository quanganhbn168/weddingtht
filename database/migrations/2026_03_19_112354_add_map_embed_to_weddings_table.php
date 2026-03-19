<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->text('groom_map_embed')->nullable()->after('groom_map_url');
            $table->text('bride_map_embed')->nullable()->after('bride_map_url');
        });
    }

    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropColumn(['groom_map_embed', 'bride_map_embed']);
        });
    }
};
