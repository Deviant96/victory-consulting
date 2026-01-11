#!/bin/bash
# Optimize Laravel application

echo "⚡ Optimizing Laravel application..."

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "✅ Application optimized successfully!"
