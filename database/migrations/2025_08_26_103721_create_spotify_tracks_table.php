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
        Schema::create('spotify_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('spotify_id')->unique();
            $table->string('name');
            $table->integer('duration_ms')->nullable(); // Duration in milliseconds
            $table->integer('track_number')->nullable();
            $table->integer('disc_number')->default(1);
            $table->boolean('explicit')->default(false);
            $table->string('preview_url')->nullable(); // 30-second preview URL
            $table->integer('popularity')->nullable(); // 0-100
            $table->json('external_urls')->nullable();
            $table->json('featured_artists')->nullable(); // Store featuring artists
            $table->boolean('is_imported')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_synced_at')->nullable();
            $table->unsignedBigInteger('spotify_artist_id');
            $table->unsignedBigInteger('spotify_album_id')->nullable();
            $table->unsignedBigInteger('local_music_id')->nullable(); // Link to local music table
            $table->timestamps();
            
            $table->index('spotify_id');
            $table->index('name');
            $table->index(['is_imported', 'is_active']);
            $table->index('popularity');
            $table->foreign('spotify_artist_id')->references('id')->on('spotify_artists')->onDelete('cascade');
            $table->foreign('spotify_album_id')->references('id')->on('spotify_albums')->onDelete('set null');
            $table->foreign('local_music_id')->references('id')->on('music')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spotify_tracks');
    }
};
