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
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Distribution Fee, Premium Subscription, etc.
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2); // Price in currency
            $table->string('currency', 3)->default('USD'); // USD, NGN, etc.
            $table->string('type')->default('one_time'); // one_time, recurring
            $table->string('interval')->nullable(); // monthly, yearly (for recurring)
            $table->json('features')->nullable(); // JSON array of features
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['type', 'is_active']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
