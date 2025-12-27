<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Consolidated Wedding Table Migration
     * Gộp tất cả fields từ các migration trước vào 1 file duy nhất
     */
    public function up(): void
    {
        Schema::create('weddings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            
            // Core fields
            $table->string('slug')->unique();
            $table->string('type')->default('wedding');
            $table->foreignId('template_id')->nullable()->constrained('templates')->nullOnDelete();
            $table->string('groom_name');
            $table->string('bride_name');
            
            // Ngày cưới chính
            $table->date('event_date');
            $table->string('event_date_lunar')->nullable(); // VD: "15/11/2024 (Ất Tỵ)"
            
            // === NHÀ TRAI (Chú rể) ===
            $table->string('groom_father')->nullable();
            $table->string('groom_mother')->nullable();
            $table->text('groom_address')->nullable();
            $table->date('groom_ceremony_date')->nullable();
            $table->time('groom_ceremony_time')->nullable();
            $table->time('groom_reception_time')->nullable();
            $table->string('groom_reception_venue')->nullable();
            $table->text('groom_reception_address')->nullable();
            $table->text('groom_map_iframe')->nullable();
            $table->string('groom_map_url')->nullable();
            $table->text('groom_qr_info')->nullable(); // JSON: bank_name, account_number, account_name
            
            // === NHÀ GÁI (Cô dâu) ===
            $table->string('bride_father')->nullable();
            $table->string('bride_mother')->nullable();
            $table->text('bride_address')->nullable();
            $table->date('bride_ceremony_date')->nullable();
            $table->time('bride_ceremony_time')->nullable();
            $table->time('bride_reception_time')->nullable();
            $table->string('bride_reception_venue')->nullable();
            $table->text('bride_reception_address')->nullable();
            $table->text('bride_map_iframe')->nullable();
            $table->string('bride_map_url')->nullable();
            $table->text('bride_qr_info')->nullable();
            
            // Tiệc cưới chung (legacy support)
            $table->date('reception_date')->nullable();
            $table->time('reception_time')->nullable();
            $table->string('reception_venue')->nullable();
            $table->text('reception_address')->nullable();
            $table->string('reception_date_lunar')->nullable();
            
            // Appearance & Settings
            $table->string('template_view')->default('templates.modern_01');
            $table->enum('status', ['draft', 'preview', 'published', 'archived'])->default('draft');
            
            // Pro Features
            $table->enum('tier', ['standard', 'pro'])->default('standard');
            $table->boolean('is_demo')->default(false);
            $table->string('falling_effect')->default('hearts');
            $table->string('preload_variant')->nullable()->default('heartbeat');
            $table->boolean('show_invitation_wrapper')->default(true);
            $table->boolean('show_preload')->default(false);
            $table->string('custom_domain')->nullable();
            $table->date('expires_at')->nullable();
            
            // Sharing & Agency
            $table->foreignId('agent_id')->nullable()->constrained('agents')->nullOnDelete();
            $table->boolean('can_share')->default(true);
            $table->string('preview_token')->nullable();
            $table->boolean('is_auto_approve_wishes')->default(false);
            
            $table->string('password')->nullable();
            $table->string('background_music')->nullable();
            
            // Flexible content (JSON)
            $table->json('content')->nullable();
            
            $table->boolean('is_active')->default(true);
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
