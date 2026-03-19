<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->foreignId('shared_music_id')->nullable()->after('background_music')
                  ->constrained('shared_musics')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropForeign(['shared_music_id']);
            $table->dropColumn('shared_music_id');
        });
    }
};
