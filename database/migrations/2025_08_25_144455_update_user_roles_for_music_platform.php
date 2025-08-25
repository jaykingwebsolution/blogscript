<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update role enum to include music platform roles
        // SQLite doesn't support modifying enums, so we need to handle this differently
        $driver = Schema::getConnection()->getDriverName();
        
        if ($driver === 'sqlite') {
            // For SQLite, we need to recreate the table with new role values
            Schema::table('users', function (Blueprint $table) {
                $table->string('role_new', 20)->default('listener');
            });
            
            // Copy existing role data with mapping
            DB::statement("UPDATE users SET role_new = CASE 
                WHEN role = 'admin' THEN 'admin'
                WHEN role = 'editor' THEN 'artist'
                WHEN role = 'user' THEN 'listener'
                ELSE 'listener'
            END");
            
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
            
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('role_new', 'role');
            });
        } else {
            // For MySQL/PostgreSQL, we can modify the enum
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'artist', 'listener', 'record_label') NOT NULL DEFAULT 'listener'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        
        if ($driver === 'sqlite') {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role_new', 20)->default('user');
            });
            
            // Reverse mapping
            DB::statement("UPDATE users SET role_new = CASE 
                WHEN role = 'admin' THEN 'admin'
                WHEN role = 'artist' THEN 'editor'
                WHEN role = 'listener' THEN 'user'
                WHEN role = 'record_label' THEN 'user'
                ELSE 'user'
            END");
            
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
            
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('role_new', 'role');
            });
        } else {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'editor', 'user') NOT NULL DEFAULT 'user'");
        }
    }
};
