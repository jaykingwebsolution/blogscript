# Database Migration Guide

## Overview

This document provides detailed information about the database migrations for the BlogScript Laravel application. All migrations have been tested and verified to work correctly in both development (SQLite) and production (MySQL) environments.

## Migration Status: ✅ PRODUCTION READY

All database migrations have been successfully tested and are ready for production deployment.

## Issues Fixed

### 1. SQLite Compatibility Issues (Migration: `2024_01_11_000000_add_relationships_and_slugs_to_existing_tables.php`)

**Problem**: The migration was attempting to perform multiple column drops and index operations in a single schema modification, which SQLite doesn't support.

**Solution**: 
- Split multiple column drops into separate `Schema::table()` calls
- Added database driver detection to skip foreign key drops for SQLite (since SQLite doesn't support dropping foreign keys)
- Made the migration compatible with both SQLite (development) and MySQL (production)

### 2. Syntax Error in User Model (app/Models/User.php)

**Problem**: Extra closing brace causing a parse error.

**Solution**: Removed the duplicate closing brace.

### 3. Database Seeder Issues (database/seeders/DatabaseSeeder.php)

**Problems**:
- Seeder was using outdated schema (trying to insert into removed columns like `category` and `tags`)
- Missing required fields added by migrations (`username`, `slug`, `category_id`)
- Duplicate user creation attempts

**Solutions**:
- Updated seeder to use `firstOrCreate()` for safer user creation
- Added category creation before content seeding
- Updated video and news data to use `category_id` instead of `category`
- Removed `tags` column references (removed by migration)
- Added required `slug` fields to all content

## Migration Order & Dependencies

The migrations run in chronological order and have the following dependencies:

1. **User & Core Tables** (2024_01_01 to 2024_01_05)
   - Creates basic tables: users, artists, music, videos, news

2. **Categories & Tags** (2024_01_06 to 2024_01_10)
   - Creates categories and tag relationship tables

3. **Schema Modifications** (2024_01_11)
   - ⚠️ **CRITICAL**: Adds relationships, slugs, and removes old columns
   - This migration required the most fixes for production compatibility

4. **Additional Features** (2024_01_12 onwards)
   - Password reset, subscriptions, verification, trending requests
   - Recent additions: plans, media, Spotify integration, notifications, user profiles

## Database Schema Changes

### Major Schema Modifications (2024_01_11 Migration)

#### Music Table
- ✅ Added: `slug` (unique)
- ✅ Added: `artist_id` (foreign key to artists)
- ✅ Added: `category_id` (foreign key to categories)

#### News Table  
- ✅ Added: `slug` (unique)
- ✅ Added: `category_id` (foreign key to categories)
- ❌ Removed: `category` (string column)
- ❌ Removed: `tags` (JSON column)

#### Videos Table
- ✅ Added: `slug` (unique) 
- ✅ Added: `category_id` (foreign key to categories)
- ❌ Removed: `category` (string column)

#### Artists Table
- ✅ Added: `username` (unique)
- ✅ Added: `slug` (unique)
- ✅ Added: `social_links` (JSON)

## Production Deployment Steps

### 1. Environment Setup

```bash
# Copy and configure environment file
cp .env.example .env

# Update database credentials in .env
DB_CONNECTION=mysql
DB_HOST=your_mysql_host
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_secure_password

# Set production environment
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

### 2. Install Dependencies

```bash
# Install PHP dependencies (production)
composer install --optimize-autoloader --no-dev

# Generate application key
php artisan key:generate
```

### 3. Database Migration & Seeding

```bash
# Run all migrations
php artisan migrate --force

# Seed initial data (admin users, categories, sample content)
php artisan db:seed

# Cache configuration for production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Production Verification

```bash
# Verify migration status
php artisan migrate:status

# Check application status
php artisan about
```

## Default Credentials

After running `php artisan db:seed`, use these default credentials:

- **Admin**: admin@blogscript.com / admin123
- **Editor**: editor@blogscript.com / editor123

⚠️ **SECURITY**: Change these passwords immediately in production!

## Rollback Instructions

If rollback is needed, migrations support proper rollback operations:

```bash
# Rollback last migration batch
php artisan migrate:rollback

# Rollback specific number of batches
php artisan migrate:rollback --step=5

# Rollback all migrations (DANGEROUS - will lose all data)
php artisan migrate:reset
```

## Database Requirements

### Development
- SQLite 3.8+ (included with PHP)
- All migrations tested and working

### Production
- MySQL 5.7+ or MariaDB 10.3+
- InnoDB storage engine (default)
- utf8mb4 character set support
- Foreign key constraint support

## Testing Migrations

### SQLite (Development)
```bash
# Fresh migration with seeding
php artisan migrate:fresh --seed

# Test rollback functionality  
php artisan migrate:rollback --step=1
php artisan migrate
```

### MySQL (Production Testing)
```bash
# Update .env to use MySQL, then:
php artisan migrate:fresh --seed --force
```

## Common Issues & Solutions

### Issue: "SQLite doesn't support multiple calls to dropColumn"
**Solution**: Already fixed in the migration files. Columns are now dropped individually.

### Issue: "SQLite doesn't support dropping foreign keys"
**Solution**: Migration automatically detects database driver and skips foreign key drops for SQLite.

### Issue: Missing columns during seeding
**Solution**: Seeder updated to match current schema. Categories are created before content.

### Issue: Duplicate key errors during seeding
**Solution**: Seeder uses `firstOrCreate()` for safe record creation.

## Migration Monitoring

For production deployments, monitor:

1. **Migration Execution Time**: The complex schema modification migration may take longer on large datasets
2. **Index Recreation**: New indexes are created - monitor query performance
3. **Foreign Key Constraints**: Ensure data integrity is maintained
4. **Storage Requirements**: Slug columns add storage overhead

## Support

If you encounter migration issues:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify database permissions and connectivity
3. Ensure all prerequisites are met
4. Check MySQL/MariaDB version compatibility

All migrations have been thoroughly tested and are production-ready.