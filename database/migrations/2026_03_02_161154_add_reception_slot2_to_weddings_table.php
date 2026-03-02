<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->date('groom_reception_date_2')->nullable()->after('groom_reception_time');
            $table->time('groom_reception_time_2')->nullable()->after('groom_reception_date_2');
            $table->date('bride_reception_date_2')->nullable()->after('bride_reception_time');
            $table->time('bride_reception_time_2')->nullable()->after('bride_reception_date_2');
        });
    }

    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropColumn([
                'groom_reception_date_2', 'groom_reception_time_2',
                'bride_reception_date_2', 'bride_reception_time_2',
            ]);
        });
    }
};
