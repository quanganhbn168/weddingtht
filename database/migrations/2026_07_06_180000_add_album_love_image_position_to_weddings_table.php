<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->string('album_love_image_position_x', 10)
                ->default('center')
                ->after('lunar_date_format');
            $table->string('album_love_image_position_y', 10)
                ->default('top')
                ->after('album_love_image_position_x');
        });
    }

    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropColumn([
                'album_love_image_position_x',
                'album_love_image_position_y',
            ]);
        });
    }
};
