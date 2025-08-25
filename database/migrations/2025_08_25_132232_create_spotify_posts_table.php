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
        Schema::create('spotify_posts', function (Blueprint $table) {
            $table->id();
            $table->string('spotify_id')->unique();
            $table->string('title');
            $table->string('artist_name');
            $table->text('description')->nullable();
            $table->string('album_name')->nullable();
            $table->string('image_url')->nullable();
            $table->string('spotify_url');
            $table->string('preview_url')->nullable();
            $table->date('release_date')->nullable();
            $table->json('artists')->nullable(); // Multiple artists
            $table->json('genres')->nullable();
            $table->string('type')->default('track'); // track, album, artist
            $table->integer('popularity')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spotify_posts');
    }
};
