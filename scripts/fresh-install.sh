#!/bin/bash
# Fresh installation - migrate and seed database

echo "🌱 Running fresh installation..."

php artisan migrate:fresh --seed

echo "✅ Fresh installation completed!"
