#!/bin/bash
# Create storage symbolic link

echo "🔗 Creating storage symbolic link..."

php artisan storage:link

echo "✅ Storage link created successfully!"
