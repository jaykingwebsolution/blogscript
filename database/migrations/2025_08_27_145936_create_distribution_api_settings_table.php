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
        Schema::create('distribution_api_settings', function (Blueprint $table) {
            $table->id();
            $table->string('provider'); // paystack, flutterwave
            $table->string('environment')->default('test'); // test, live
            $table->string('public_key')->nullable();
            $table->text('secret_key')->nullable(); // Encrypted
            $table->json('configuration')->nullable(); // Additional settings
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            
            $table->unique(['provider', 'environment']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_api_settings');
    }
};
