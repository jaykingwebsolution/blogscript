# Production Deployment Guide

## Prerequisites
- PHP 8.1 or higher
- MySQL 5.7 or higher / MariaDB 10.3 or higher
- Composer
- Node.js and npm (for frontend assets)
- Web server (Apache/Nginx)

## Deployment Steps

### 1. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Update database configuration in .env
DB_CONNECTION=mysql
DB_HOST=your_host
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Set APP_ENV to production
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install frontend dependencies
npm install

# Build production assets
npm run build
```

### 3. Application Setup
```bash
# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# Seed initial data (admin user)
php artisan db:seed

# Cache configuration for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage symlink
php artisan storage:link
```

### 4. File Permissions
```bash
# Set appropriate permissions
chown -R www-data:www-data storage/ bootstrap/cache/
chmod -R 755 storage/ bootstrap/cache/
```

### 5. Web Server Configuration

#### Apache (.htaccess in public folder)
```apache
Options -MultiViews -Indexes
RewriteEngine On

# Handle Authorization Header
RewriteCond %{HTTP:Authorization} .
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

# Redirect Trailing Slashes If Not A Folder...
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_URI} (.+)/$
RewriteRule ^ %1 [L,R=301]

# Send Requests To Front Controller...
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]
```

#### Nginx Configuration
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/your/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Default Login Credentials

After running `php artisan db:seed`, use these credentials:

### Admin Access
- **Email**: admin@blogscript.com
- **Password**: admin123
- **Role**: Admin (full access)

### Editor Access
- **Email**: editor@blogscript.com
- **Password**: editor123
- **Role**: Editor (content management)

## Security Considerations

1. **Change Default Passwords**: Immediately change default admin/editor passwords in production
2. **SSL Certificate**: Always use HTTPS in production
3. **Database Security**: Use strong database passwords and restrict access
4. **File Uploads**: Configure proper file upload validation and storage
5. **Error Reporting**: Disable debug mode in production (`APP_DEBUG=false`)
6. **Regular Updates**: Keep Laravel and dependencies updated

## Maintenance Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check application status
php artisan about

# Run scheduled tasks (add to cron)
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

## Monitoring and Logs

- Application logs: `storage/logs/laravel.log`
- Error logs: Check web server error logs
- Monitor disk space for uploaded files
- Monitor database performance and size