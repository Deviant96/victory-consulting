@echo off
REM Quick shortcuts for Windows

if "%1"=="clear" (
    echo Clearing Laravel caches...
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    php artisan event:clear
    echo Done!
    goto :eof
)

if "%1"=="optimize" (
    echo Optimizing Laravel application...
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache
    echo Done!
    goto :eof
)

if "%1"=="restart" (
    echo Restarting Laravel application...
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    php artisan event:clear
    php artisan clear-compiled
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    echo Done!
    goto :eof
)

if "%1"=="fresh" (
    echo Running fresh installation...
    php artisan migrate:fresh --seed
    echo Done!
    goto :eof
)

if "%1"=="migrate" (
    echo Running migrations...
    php artisan migrate
    echo Done!
    goto :eof
)

if "%1"=="seed" (
    echo Seeding database...
    php artisan db:seed
    echo Done!
    goto :eof
)

if "%1"=="serve" (
    echo Starting development server...
    php artisan serve
    goto :eof
)

if "%1"=="test" (
    echo Running tests...
    php artisan test
    goto :eof
)

if "%1"=="logs" (
    type storage\logs\laravel.log
    goto :eof
)

echo Laravel Development Shortcuts
echo ================================
echo.
echo Usage: dev [command]
echo.
echo Available commands:
echo   clear      - Clear all caches
echo   optimize   - Optimize application
echo   restart    - Restart application (clear + optimize)
echo   fresh      - Fresh install (migrate:fresh --seed)
echo   migrate    - Run migrations
echo   seed       - Seed database
echo   serve      - Start development server
echo   test       - Run tests
echo   logs       - View logs
echo.
echo For interactive menu, run: bash dev.sh
