#!/bin/bash
# Laravel Development Shortcuts Menu

show_menu() {
    clear
    echo "╔════════════════════════════════════════════╗"
    echo "║   Laravel Development Shortcuts Menu      ║"
    echo "╚════════════════════════════════════════════╝"
    echo ""
    echo "  Cache Management:"
    echo "  1)  Clear all caches"
    echo "  2)  Optimize application"
    echo "  3)  Restart application (clear + optimize)"
    echo ""
    echo "  Database:"
    echo "  4)  Run migrations"
    echo "  5)  Seed database"
    echo "  6)  Fresh install (migrate:fresh --seed)"
    echo ""
    echo "  Development:"
    echo "  7)  Create storage link"
    echo "  8)  View logs (last 50 lines)"
    echo "  9)  Run tests"
    echo "  10) Start development server"
    echo "  11) Watch assets (npm run dev)"
    echo ""
    echo "  Composer & NPM:"
    echo "  12) Composer install"
    echo "  13) Composer update"
    echo "  14) NPM install"
    echo "  15) NPM build"
    echo ""
    echo "  Other:"
    echo "  16) Generate APP_KEY"
    echo "  17) List all routes"
    echo "  18) Queue worker"
    echo ""
    echo "  0)  Exit"
    echo ""
    echo "────────────────────────────────────────────"
}

execute_command() {
    case $1 in
        1)
            bash scripts/clear-cache.sh
            ;;
        2)
            bash scripts/optimize.sh
            ;;
        3)
            bash scripts/restart.sh
            ;;
        4)
            bash scripts/migrate.sh
            ;;
        5)
            bash scripts/seed.sh
            ;;
        6)
            bash scripts/fresh-install.sh
            ;;
        7)
            bash scripts/storage-link.sh
            ;;
        8)
            bash scripts/logs.sh
            ;;
        9)
            bash scripts/test.sh
            ;;
        10)
            echo "🚀 Starting development server on http://localhost:8000"
            php artisan serve
            ;;
        11)
            echo "👀 Starting asset watcher..."
            npm run dev
            ;;
        12)
            echo "📦 Installing Composer dependencies..."
            composer install
            ;;
        13)
            echo "📦 Updating Composer dependencies..."
            composer update
            ;;
        14)
            echo "📦 Installing NPM dependencies..."
            npm install
            ;;
        15)
            echo "📦 Building assets for production..."
            npm run build
            ;;
        16)
            echo "🔑 Generating application key..."
            php artisan key:generate
            ;;
        17)
            echo "📋 Listing all routes..."
            php artisan route:list
            ;;
        18)
            echo "⚙️  Starting queue worker..."
            php artisan queue:work
            ;;
        0)
            echo "👋 Goodbye!"
            exit 0
            ;;
        *)
            echo "❌ Invalid option. Please try again."
            ;;
    esac
}

# Main loop
while true; do
    show_menu
    read -p "Select an option (0-18): " choice
    echo ""
    execute_command $choice
    echo ""
    read -p "Press Enter to continue..."
done
