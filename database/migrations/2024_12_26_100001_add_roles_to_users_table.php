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
        Schema::table('users', function (Blueprint $table) {
            // User roles: admin (GOD), agent (đại lý), customer (cô dâu chú rể)
            $table->enum('role', ['admin', 'agent', 'customer'])->default('customer')->after('email');
            
            // Link to agent who created this customer account
            $table->foreignId('agent_id')->nullable()->after('role')->constrained('users')->nullOnDelete();
            
            // Who created this account (admin or agent)
            $table->foreignId('created_by')->nullable()->after('agent_id')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['agent_id']);
            $table->dropForeign(['created_by']);
            $table->dropColumn(['role', 'agent_id', 'created_by']);
        });
    }
};
