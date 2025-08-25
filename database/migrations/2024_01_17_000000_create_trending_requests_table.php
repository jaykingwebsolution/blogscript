<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trending_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['week', 'month', 'all-time'])->default('week');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('message')->nullable(); // User's message/reason for trending request
            $table->text('admin_notes')->nullable(); // Admin notes for approval/rejection
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('expires_at')->nullable(); // When trending status expires
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trending_requests');
    }
};