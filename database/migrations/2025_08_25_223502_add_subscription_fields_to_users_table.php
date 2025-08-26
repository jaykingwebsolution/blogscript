<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('subscription_status', ['inactive', 'active', 'expired', 'cancelled'])->default('inactive');
            $table->unsignedBigInteger('subscription_plan_id')->nullable();
            $table->timestamp('subscription_paid_at')->nullable();
            $table->timestamp('subscription_expires_at')->nullable();
            
            $table->foreign('subscription_plan_id')->references('id')->on('pricing_plans')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['subscription_plan_id']);
            $table->dropColumn([
                'subscription_status',
                'subscription_plan_id', 
                'subscription_paid_at',
                'subscription_expires_at'
            ]);
        });
    }
};
