<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->string('groom_qr_bank_id', 20)->nullable()->after('groom_qr_info');
            $table->string('groom_qr_account_number', 32)->nullable()->after('groom_qr_bank_id');
            $table->string('groom_qr_account_name')->nullable()->after('groom_qr_account_number');
            $table->unsignedBigInteger('groom_qr_amount')->nullable()->after('groom_qr_account_name');
            $table->string('groom_qr_add_info', 100)->nullable()->after('groom_qr_amount');

            $table->string('bride_qr_bank_id', 20)->nullable()->after('bride_qr_info');
            $table->string('bride_qr_account_number', 32)->nullable()->after('bride_qr_bank_id');
            $table->string('bride_qr_account_name')->nullable()->after('bride_qr_account_number');
            $table->unsignedBigInteger('bride_qr_amount')->nullable()->after('bride_qr_account_name');
            $table->string('bride_qr_add_info', 100)->nullable()->after('bride_qr_amount');
        });
    }

    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropColumn([
                'groom_qr_bank_id',
                'groom_qr_account_number',
                'groom_qr_account_name',
                'groom_qr_amount',
                'groom_qr_add_info',
                'bride_qr_bank_id',
                'bride_qr_account_number',
                'bride_qr_account_name',
                'bride_qr_amount',
                'bride_qr_add_info',
            ]);
        });
    }
};
