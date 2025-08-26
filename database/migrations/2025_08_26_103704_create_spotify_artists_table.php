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
        Schema::create('spotify_artists', function (Blueprint $table) {
            $table->id();
            $table->string('spotify_id')->unique();
            $table->string('name');
            $table->text('bio')->nullable();
            $table->string('image_url')->nullable();
            $table->json('genres')->nullable(); // Store as JSON array
            $table->string('popularity')->nullable();
            $table->integer('followers')->default(0);
            $table->json('external_urls')->nullable(); // Store Spotify URLs
            $table->boolean('is_imported')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_synced_at')->nullable();
            $table->unsignedBigInteger('local_artist_id')->nullable(); // Link to local artists table
            $table->timestamps();
            
            $table->index('spotify_id');
            $table->index('name');
            $table->index(['is_imported', 'is_active']);
            $table->foreign('local_artist_id')->references('id')->on('artists')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spotify_artists');
    }
};
