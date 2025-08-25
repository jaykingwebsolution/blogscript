<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('music', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title');
            $table->foreignId('artist_id')->nullable()->constrained()->after('artist_name');
            $table->foreignId('category_id')->nullable()->constrained()->after('genre');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title');
            $table->foreignId('category_id')->nullable()->constrained()->after('excerpt');
            
            // Drop indexes first before dropping columns (required for SQLite)
            $table->dropIndex(['category', 'status']); // news_category_status_index
            $table->dropColumn('category');
            $table->dropColumn('tags');
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title');
            $table->foreignId('category_id')->nullable()->constrained()->after('duration');
            
            // Drop indexes first before dropping columns (required for SQLite)
            $table->dropIndex(['category', 'status']); // videos_category_status_index
            $table->dropColumn('category');
        });

        Schema::table('artists', function (Blueprint $table) {
            $table->string('username')->unique()->after('name');
            $table->string('slug')->unique()->after('username');
            $table->json('social_links')->nullable()->after('country');
        });
    }

    public function down()
    {
        Schema::table('music', function (Blueprint $table) {
            $table->dropForeign(['artist_id']);
            $table->dropForeign(['category_id']);
            $table->dropColumn(['slug', 'artist_id', 'category_id']);
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['slug', 'category_id']);
            $table->string('category')->after('excerpt');
            $table->json('tags')->after('category');
            
            // Recreate the indexes that were dropped
            $table->index(['category', 'status']);
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['slug', 'category_id']);
            $table->string('category')->after('duration');
            
            // Recreate the indexes that were dropped
            $table->index(['category', 'status']);
        });

        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn(['username', 'slug', 'social_links']);
        });
    }
};