<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create payment_transactions table to track all payment attempts.
     */
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_id')->unique();
            $table->string('request_id')->nullable();
            $table->string('trans_id')->nullable(); // MoMo transaction ID
            $table->string('gateway')->default('momo'); // momo, vnpay, stripe
            $table->string('plan'); // pro, enterprise
            $table->integer('amount'); // Amount in VND
            $table->string('status')->default('pending'); // pending, success, failed, cancelled
            $table->string('pay_type')->nullable(); // qr, napas, credit
            $table->json('response_data')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
