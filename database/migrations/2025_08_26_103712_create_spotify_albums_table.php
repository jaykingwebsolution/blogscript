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
        Schema::create('spotify_albums', function (Blueprint $table) {
            $table->id();
            $table->string('spotify_id')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('album_type'); // album, single, compilation
            $table->string('image_url')->nullable();
            $table->date('release_date')->nullable();
            $table->string('release_date_precision')->nullable(); // year, month, day
            $table->integer('total_tracks')->default(0);
            $table->json('genres')->nullable();
            $table->json('external_urls')->nullable();
            $table->boolean('is_imported')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_synced_at')->nullable();
            $table->unsignedBigInteger('spotify_artist_id');
            $table->timestamps();
            
            $table->index('spotify_id');
            $table->index('name');
            $table->index('album_type');
            $table->index(['is_imported', 'is_active']);
            $table->foreign('spotify_artist_id')->references('id')->on('spotify_artists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spotify_albums');
    }
};
