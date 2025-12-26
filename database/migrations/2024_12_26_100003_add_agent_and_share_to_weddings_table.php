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
        Schema::table('weddings', function (Blueprint $table) {
            // Link to agent who created this wedding
            $table->foreignId('agent_id')->nullable()->after('user_id')->constrained('agents')->nullOnDelete();
            
            // Share/Publish control
            // false = only owner can view (private link, must login)
            // true = anyone with link can view (public)
            $table->boolean('can_share')->default(false)->after('status');
            
            // Preview token for demo viewing (logged-in user only)
            $table->string('preview_token')->nullable()->after('can_share');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropForeign(['agent_id']);
            $table->dropColumn(['agent_id', 'can_share', 'preview_token']);
        });
    }
};
