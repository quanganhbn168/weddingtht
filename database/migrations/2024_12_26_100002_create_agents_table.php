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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            
            // Link to user account
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Business info
            $table->string('business_name'); // Tên tiệm/studio
            $table->enum('business_type', ['print', 'photo', 'studio', 'wedding_planner', 'other'])->default('other');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('tax_code')->nullable(); // Mã số thuế
            
            // Subscription & Quota
            $table->enum('subscription_plan', ['trial', 'basic', 'pro', 'enterprise'])->default('trial');
            $table->integer('quota_weddings')->default(5); // Số wedding được tạo
            $table->integer('quota_used')->default(0);
            $table->timestamp('trial_ends_at')->nullable(); // 1 tháng trial
            $table->timestamp('subscription_ends_at')->nullable();
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_verified')->default(false); // Admin verify
            
            // Notes
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
