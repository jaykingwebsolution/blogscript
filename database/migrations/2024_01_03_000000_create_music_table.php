<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('music', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('artist_name');
            $table->string('image_url')->nullable();
            $table->string('audio_url')->nullable();
            $table->string('duration')->nullable();
            $table->string('genre')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['status', 'is_featured']);
            $table->index(['genre', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('music');
    }
};