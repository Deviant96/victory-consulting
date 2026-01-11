#!/bin/bash
# Seed database

echo "🌱 Seeding database..."

php artisan db:seed

echo "✅ Database seeded successfully!"
