# MySQL Database Setup Guide for MusicStream Platform

## Database Configuration Changed from SQLite to MySQL

✅ **CHANGES IMPLEMENTED:**

1. **Removed SQLite database file** (`database/database.sqlite`)
2. **Updated .env configuration** for MySQL
3. **Database configuration ready** for MySQL production deployment

## MySQL Setup Instructions

### 1. Install MySQL Server
```bash
# Ubuntu/Debian
sudo apt update
sudo apt install mysql-server

# CentOS/RHEL
sudo yum install mysql-server

# Start MySQL service
sudo systemctl start mysql
sudo systemctl enable mysql
```

### 2. Secure MySQL Installation
```bash
sudo mysql_secure_installation
```

### 3. Create Database and User
```sql
-- Login to MySQL as root
mysql -u root -p

-- Create database
CREATE DATABASE musicstream_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create dedicated user
CREATE USER 'musicstream_user'@'localhost' IDENTIFIED BY 'your_secure_password_here';

-- Grant privileges
GRANT ALL PRIVILEGES ON musicstream_db.* TO 'musicstream_user'@'localhost';
FLUSH PRIVILEGES;

-- Exit MySQL
EXIT;
```

### 4. Update .env Configuration
```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=musicstream_db
DB_USERNAME=musicstream_user
DB_PASSWORD=your_secure_password_here
```

### 5. Run Migrations
```bash
php artisan migrate
php artisan db:seed
```

## Production Deployment Notes

### Database Configuration
- **Engine**: MySQL 8.0+ recommended
- **Character Set**: utf8mb4
- **Collation**: utf8mb4_unicode_ci
- **Storage Engine**: InnoDB (default)

### Performance Optimization
```sql
-- Recommended MySQL configuration in my.cnf
[mysqld]
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
max_connections = 200
query_cache_type = 1
query_cache_size = 64M
```

### Security Best Practices
1. Use strong passwords for database users
2. Limit database user privileges to only required operations
3. Use SSL connections for remote database access
4. Regular database backups
5. Keep MySQL server updated

### Backup Strategy
```bash
# Daily backup script
mysqldump -u musicstream_user -p musicstream_db > backup_$(date +%Y%m%d).sql

# Automated backup with cron
0 2 * * * mysqldump -u musicstream_user -p'password' musicstream_db > /backups/musicstream_$(date +\%Y\%m\%d).sql
```

## Migration Compatibility

The migration files are already optimized for MySQL:
- ✅ Foreign key constraints properly handled
- ✅ Enum fields use MySQL syntax when detected
- ✅ Index creation optimized for MySQL
- ✅ UTF8MB4 character set support

## Environment Variables

All database-related environment variables updated:
```env
DB_CONNECTION=mysql          # Changed from sqlite
DB_HOST=localhost           # MySQL server host
DB_PORT=3306               # MySQL default port
DB_DATABASE=musicstream_db # Database name
DB_USERNAME=musicstream_user # Database user
DB_PASSWORD=secure_password  # Strong password
```

## Verification

To verify MySQL setup is working:
```bash
# Test database connection
php artisan migrate:status

# Run all migrations
php artisan migrate

# Seed the database
php artisan db:seed
```

Your Laravel MusicStream platform is now configured for MySQL production deployment!