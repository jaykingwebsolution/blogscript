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
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->enum('type', ['feature', 'trending_song', 'trending_artist', 'general'])->default('general');
            $table->boolean('is_global')->default(true); // Send to all users
            $table->json('target_roles')->nullable(); // Specific roles to notify
            $table->json('target_users')->nullable(); // Specific users to notify
            $table->string('action_url')->nullable(); // Link to click
            $table->string('icon')->nullable(); // Icon class or URL
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};
