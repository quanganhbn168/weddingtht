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
        Schema::create('weddings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('groom_name');
            $table->string('bride_name');
            $table->date('event_date');
            
            // Quản lý trạng thái & Giao diện
            $table->string('template_view')->default('templates.modern_01');
            $table->enum('status', ['draft', 'preview', 'published', 'archived'])->default('draft');
            
            // Bảo mật & Quyền hạn
            $table->uuid('edit_token')->unique();
            $table->string('password')->nullable();
            
            // Dữ liệu động (JSON)
            // Lưu: video_url, map_url, wishes, colors, fonts, music_url...
            $table->json('content')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weddings');
    }
};
