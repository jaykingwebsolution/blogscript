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
        if (!Schema::hasTable('distribution_assets')) {
            Schema::create('distribution_assets', function (Blueprint $table) {
                $table->id();
                $table->foreignId('distribution_request_id')->constrained()->onDelete('cascade');
                $table->string('asset_type'); // audio, cover_image, additional_art
                $table->string('file_path');
                $table->string('file_name');
                $table->string('file_size')->nullable();
                $table->string('mime_type');
                $table->json('metadata')->nullable(); // Additional file metadata
                $table->timestamps();
                
                $table->index(['distribution_request_id', 'asset_type']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_assets');
    }
};
