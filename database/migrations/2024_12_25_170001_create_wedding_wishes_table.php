<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Wedding Wishes - Sổ lưu bút / Lời chúc
     */
    public function up(): void
    {
        Schema::create('wedding_wishes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('message');
            $table->boolean('is_approved')->default(false);
            $table->string('ip_address')->nullable();
            $table->timestamps();
            
            $table->index(['wedding_id', 'is_approved']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wedding_wishes');
    }
};
