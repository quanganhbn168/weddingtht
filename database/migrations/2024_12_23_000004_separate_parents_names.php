<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            // Tách tên cha mẹ
            $table->string('groom_father')->nullable();
            $table->string('groom_mother')->nullable();
            $table->string('bride_father')->nullable();
            $table->string('bride_mother')->nullable();
            
            // Xóa các field cũ nếu cần, hoặc cứ để đó migrate data sau
            // $table->dropColumn(['groom_parents', 'bride_parents']);
        });
    }

    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropColumn(['groom_father', 'groom_mother', 'bride_father', 'bride_mother']);
        });
    }
};
