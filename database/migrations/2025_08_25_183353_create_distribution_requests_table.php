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
        Schema::create('distribution_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('artist_name');
            $table->string('song_title');
            $table->string('genre');
            $table->date('release_date');
            $table->string('cover_image')->nullable();
            $table->string('audio_file')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_requests');
    }
};
