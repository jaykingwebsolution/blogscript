<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add new user profile fields
            $table->text('bio')->nullable();
            $table->string('profile_picture')->nullable();
            $table->json('social_links')->nullable();
            $table->string('artist_stage_name')->nullable();
            $table->string('artist_genre')->nullable();
            $table->enum('verification_status', ['unverified', 'pending', 'verified'])->default('unverified');
            $table->timestamp('active_since')->nullable();
            
            // Update role enum to include new roles
            $table->enum('role', ['listener', 'artist', 'record_label', 'admin', 'editor'])->default('listener')->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bio',
                'profile_picture',
                'social_links',
                'artist_stage_name',
                'artist_genre',
                'verification_status',
                'active_since'
            ]);
        });
    }
};