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
        if (Schema::hasTable('aggregator_settings')) {
            return;
        }

        Schema::create('aggregator_settings', function (Blueprint $table) {
            $table->id();
            $table->string('provider'); // sonosuite, fuga, audiosalad, vydia
            $table->string('environment')->default('test'); // test, live
            $table->string('public_key')->nullable();
            $table->text('secret_key')->nullable(); // Encrypted
            $table->json('configuration')->nullable(); // API endpoints, additional settings
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
        Schema::dropIfExists('aggregator_settings');
    }
};
