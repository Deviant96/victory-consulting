#!/bin/bash
# Restart Laravel application

echo "🔄 Restarting Laravel application..."

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# Clear compiled files
php artisan clear-compiled

# Recreate cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Application restarted successfully!"
