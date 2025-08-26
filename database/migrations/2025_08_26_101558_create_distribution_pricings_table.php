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
        Schema::create('distribution_pricings', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Plan name
            $table->string('duration'); // '6 months', '1 year', 'lifetime'
            $table->decimal('price', 10, 2); // Price
            $table->timestamps();
            
            $table->index('duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_pricings');
    }
};
