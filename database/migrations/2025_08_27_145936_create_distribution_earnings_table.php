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
        Schema::create('distribution_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distribution_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('platform'); // spotify, apple_music, boomplay, etc.
            $table->string('territory')->nullable(); // Country/region
            $table->decimal('amount', 10, 4); // Earnings amount
            $table->string('currency', 3)->default('USD');
            $table->integer('streams')->default(0);
            $table->integer('downloads')->default(0);
            $table->date('period_start');
            $table->date('period_end');
            $table->enum('status', ['pending', 'confirmed', 'disputed'])->default('pending');
            $table->timestamps();
            
            $table->index(['user_id', 'platform', 'status']);
            $table->index(['distribution_request_id', 'period_start', 'period_end']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_earnings');
    }
};
