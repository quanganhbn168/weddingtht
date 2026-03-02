<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * RSVP - Xác nhận tham dự đám cưới
     */
    public function up(): void
    {
        Schema::create('wedding_rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->enum('attendance', ['yes', 'no', 'maybe'])->default('yes');
            $table->integer('guests')->default(1); // Số người đi cùng
            $table->enum('side', ['groom', 'bride', 'both'])->default('both'); // Nhà trai/gái
            $table->text('note')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
            
            $table->index(['wedding_id', 'attendance']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wedding_rsvps');
    }
};
