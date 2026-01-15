<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create settings table for admin-editable configurations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, integer, json, boolean
            $table->string('group')->default('general'); // pricing, general, etc
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default pricing settings
        $settings = [
            // Retail pricing
            ['key' => 'price_basic', 'value' => '198000', 'type' => 'integer', 'group' => 'pricing_retail', 'label' => 'Giá gói Cơ bản (VNĐ)'],
            ['key' => 'price_standard', 'value' => '299000', 'type' => 'integer', 'group' => 'pricing_retail', 'label' => 'Giá gói Tiêu chuẩn (VNĐ)'],
            ['key' => 'price_pro', 'value' => '499000', 'type' => 'integer', 'group' => 'pricing_retail', 'label' => 'Giá gói Pro (VNĐ)'],
            
            // Agent pricing
            ['key' => 'agent_price_basic', 'value' => '199000', 'type' => 'integer', 'group' => 'pricing_agent', 'label' => 'Giá gói Đại lý Cơ bản (VNĐ/tháng)'],
            ['key' => 'agent_price_standard', 'value' => '499000', 'type' => 'integer', 'group' => 'pricing_agent', 'label' => 'Giá gói Đại lý Tiêu chuẩn (VNĐ/tháng)'],
            ['key' => 'agent_price_enterprise', 'value' => '999000', 'type' => 'integer', 'group' => 'pricing_agent', 'label' => 'Giá gói Đại lý Doanh nghiệp (VNĐ/tháng)'],
            
            // Agent quotas
            ['key' => 'agent_quota_basic', 'value' => '10', 'type' => 'integer', 'group' => 'pricing_agent', 'label' => 'Quota gói Đại lý Cơ bản'],
            ['key' => 'agent_quota_standard', 'value' => '30', 'type' => 'integer', 'group' => 'pricing_agent', 'label' => 'Quota gói Đại lý Tiêu chuẩn'],
            
            // Tier limits
            ['key' => 'photos_basic', 'value' => '20', 'type' => 'integer', 'group' => 'tier_limits', 'label' => 'Số ảnh gói Cơ bản'],
            ['key' => 'photos_standard', 'value' => '40', 'type' => 'integer', 'group' => 'tier_limits', 'label' => 'Số ảnh gói Tiêu chuẩn'],
            ['key' => 'expires_basic', 'value' => '6', 'type' => 'integer', 'group' => 'tier_limits', 'label' => 'Thời hạn gói Cơ bản (tháng)'],
            ['key' => 'expires_standard', 'value' => '12', 'type' => 'integer', 'group' => 'tier_limits', 'label' => 'Thời hạn gói Tiêu chuẩn (tháng)'],
        ];

        foreach ($settings as $setting) {
            \DB::table('settings')->insert(array_merge($setting, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
