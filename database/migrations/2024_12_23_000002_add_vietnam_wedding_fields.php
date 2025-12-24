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
            // === SỰ KIỆN: TIỆC CƯỚI (tối hôm trước) ===
            $table->date('reception_date')->nullable()->after('event_date');
            $table->time('reception_time')->nullable();
            $table->string('reception_venue')->nullable();
            $table->text('reception_address')->nullable();
            
            // === NGÀY ÂM LỊCH ===
            $table->string('event_date_lunar')->nullable()->after('event_date'); // VD: "15/11/2024 (Ất Tỵ)"
            $table->string('reception_date_lunar')->nullable();
            
            // === NHÀ TRAI (Chú rể) ===
            $table->time('groom_ceremony_time')->nullable(); // Giờ đón dâu bên trai
            $table->text('groom_address')->nullable();
            $table->text('groom_map_iframe')->nullable();
            $table->string('groom_map_url')->nullable();
            $table->text('groom_qr_info')->nullable(); // JSON: bank_name, account_number, account_name
            
            // === NHÀ GÁI (Cô dâu) ===
            $table->time('bride_ceremony_time')->nullable(); // Giờ lễ vu quy
            $table->text('bride_address')->nullable();
            $table->text('bride_map_iframe')->nullable();
            $table->string('bride_map_url')->nullable();
            $table->text('bride_qr_info')->nullable(); // JSON: bank_name, account_number, account_name
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropColumn([
                'reception_date', 'reception_time', 'reception_venue', 'reception_address',
                'event_date_lunar', 'reception_date_lunar',
                'groom_ceremony_time', 'groom_address', 'groom_map_iframe', 'groom_map_url', 'groom_qr_info',
                'bride_ceremony_time', 'bride_address', 'bride_map_iframe', 'bride_map_url', 'bride_qr_info',
            ]);
        });
    }
};
