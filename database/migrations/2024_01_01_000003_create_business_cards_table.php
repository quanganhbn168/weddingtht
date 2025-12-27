<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Consolidated Business Cards Table Migration
     */
    public function up(): void
    {
        Schema::create('business_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('slug')->unique(); // e.g. /p/quang-anh
            $table->string('name');
            $table->string('title')->nullable(); // Chức vụ
            $table->string('company')->nullable();
            
            // Contact
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            
            // Bio & Socials
            $table->text('about')->nullable();
            $table->json('content')->nullable(); // Flexible data for landing page sections
            $table->json('social_links')->nullable(); // { facebook: url, tiktok: url, bank: { ... } }
            
            // Appearance
            $table->foreignId('template_id')->nullable()->constrained('templates')->nullOnDelete();
            $table->string('theme_color')->nullable();
            $table->string('avatar_url')->nullable();
            
            // Settings
            $table->boolean('is_active')->default(true);
            $table->boolean('is_demo')->default(false);
            $table->string('password')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_cards');
    }
};
