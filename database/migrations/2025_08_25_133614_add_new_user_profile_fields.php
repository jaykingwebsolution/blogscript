<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable();
            }
            if (!Schema::hasColumn('users', 'profile_picture')) {
                $table->string('profile_picture')->nullable();
            }
            if (!Schema::hasColumn('users', 'social_links')) {
                $table->json('social_links')->nullable();
            }
            if (!Schema::hasColumn('users', 'artist_stage_name')) {
                $table->string('artist_stage_name')->nullable();
            }
            if (!Schema::hasColumn('users', 'artist_genre')) {
                $table->string('artist_genre')->nullable();
            }
            if (!Schema::hasColumn('users', 'verification_status')) {
                $table->string('verification_status')->default('unverified'); // Use string instead of enum for compatibility
            }
            if (!Schema::hasColumn('users', 'active_since')) {
                $table->timestamp('active_since')->nullable();
            }
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
