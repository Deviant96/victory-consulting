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
        Schema::table('push_subscriptions', function (Blueprint $table) {
            // Drop the composite unique constraint first
            $table->dropUnique('user_endpoint_unique');
            
            // Change endpoint to TEXT to support longer URLs (WNS endpoints can be very long)
            $table->text('endpoint')->change();
            
            // Re-add the composite unique constraint
            $table->unique(['user_id', 'endpoint'], 'user_endpoint_unique')->length(500);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('push_subscriptions', function (Blueprint $table) {
            // Drop the composite unique constraint
            $table->dropUnique('user_endpoint_unique');
            
            // Change endpoint back to string
            $table->string('endpoint')->change();
            
            // Re-add the composite unique constraint with original structure
            $table->unique(['user_id', 'endpoint'], 'user_endpoint_unique')->length(500);
        });
    }
};
