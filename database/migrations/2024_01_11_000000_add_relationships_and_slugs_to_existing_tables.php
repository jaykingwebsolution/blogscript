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
        });
        
        // Drop index separately for SQLite compatibility
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex(['category', 'status']); // news_category_status_index
        });
        
        // Drop columns separately for SQLite compatibility  
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('category');
        });
        
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('tags');
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title');
            $table->foreignId('category_id')->nullable()->constrained()->after('duration');
        });
        
        // Drop index separately for SQLite compatibility
        Schema::table('videos', function (Blueprint $table) {
            $table->dropIndex(['category', 'status']); // videos_category_status_index
        });
        
        // Drop column separately for SQLite compatibility
        Schema::table('videos', function (Blueprint $table) {
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
        $driverName = Schema::connection(null)->getConnection()->getDriverName();
        
        // Drop foreign keys and columns separately for SQLite compatibility
        if ($driverName !== 'sqlite') {
            Schema::table('music', function (Blueprint $table) {
                $table->dropForeign(['artist_id']);
            });
            
            Schema::table('music', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
            });
        }
        
        Schema::table('music', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
        
        Schema::table('music', function (Blueprint $table) {
            $table->dropColumn('artist_id');
        });
        
        Schema::table('music', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });

        // Drop foreign keys and columns separately for SQLite compatibility
        if ($driverName !== 'sqlite') {
            Schema::table('news', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
            });
        }
        
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
        
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
        
        Schema::table('news', function (Blueprint $table) {
            $table->string('category')->after('excerpt');
            $table->json('tags')->after('category');
            
            // Recreate the indexes that were dropped
            $table->index(['category', 'status']);
        });

        // Drop foreign keys and columns separately for SQLite compatibility
        if ($driverName !== 'sqlite') {
            Schema::table('videos', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
            });
        }
        
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
        
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
        
        Schema::table('videos', function (Blueprint $table) {
            $table->string('category')->after('duration');
            
            // Recreate the indexes that were dropped
            $table->index(['category', 'status']);
        });

        // Drop columns separately for SQLite compatibility
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn('username');
        });
        
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
        
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn('social_links');
        });
    }
};