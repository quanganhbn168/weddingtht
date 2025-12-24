<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            // Nhà trai - tiệc cưới
            if (!Schema::hasColumn('weddings', 'groom_reception_time')) {
                $table->time('groom_reception_time')->nullable();
            }
            if (!Schema::hasColumn('weddings', 'groom_reception_venue')) {
                $table->string('groom_reception_venue')->nullable();
            }
            if (!Schema::hasColumn('weddings', 'groom_reception_address')) {
                $table->text('groom_reception_address')->nullable();
            }
            if (!Schema::hasColumn('weddings', 'groom_ceremony_date')) {
                $table->date('groom_ceremony_date')->nullable();
            }
            
            // Nhà gái - tiệc cưới  
            if (!Schema::hasColumn('weddings', 'bride_reception_time')) {
                $table->time('bride_reception_time')->nullable();
            }
            if (!Schema::hasColumn('weddings', 'bride_reception_venue')) {
                $table->string('bride_reception_venue')->nullable();
            }
            if (!Schema::hasColumn('weddings', 'bride_reception_address')) {
                $table->text('bride_reception_address')->nullable();
            }
            if (!Schema::hasColumn('weddings', 'bride_ceremony_date')) {
                $table->date('bride_ceremony_date')->nullable();
            }
            
            // Thông tin cha mẹ
            if (!Schema::hasColumn('weddings', 'groom_parents')) {
                $table->text('groom_parents')->nullable();
            }
            if (!Schema::hasColumn('weddings', 'bride_parents')) {
                $table->text('bride_parents')->nullable();
            }
            
            // Nhạc nền
            if (!Schema::hasColumn('weddings', 'background_music')) {
                $table->string('background_music')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropColumn([
                'groom_reception_time',
                'groom_reception_venue', 
                'groom_reception_address',
                'groom_ceremony_date',
                'bride_reception_time',
                'bride_reception_venue',
                'bride_reception_address',
                'bride_ceremony_date',
                'groom_parents',
                'bride_parents',
                'background_music',
            ]);
        });
    }
};
