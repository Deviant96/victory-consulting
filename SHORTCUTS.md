# Laravel Development Shortcuts

This project includes a convenient shortcut system to make common Laravel development tasks easier and faster.

## Quick Start

### Interactive Menu (Recommended)
Run the interactive menu for all available options:
```bash
bash dev.sh
```

### Windows Quick Commands
For quick one-line commands on Windows:
```cmd
dev clear      # Clear all caches
dev optimize   # Optimize application
dev restart    # Restart application
dev fresh      # Fresh install (migrate:fresh --seed)
dev migrate    # Run migrations
dev seed       # Seed database
dev serve      # Start development server
dev test       # Run tests
dev logs       # View logs
```

### Bash Scripts
Individual scripts in the `scripts/` directory:
```bash
bash scripts/clear-cache.sh
bash scripts/optimize.sh
bash scripts/restart.sh
bash scripts/fresh-install.sh
bash scripts/migrate.sh
bash scripts/seed.sh
bash scripts/storage-link.sh
bash scripts/logs.sh
bash scripts/test.sh
```

## Available Commands

### Cache Management
- **Clear Caches** - Clears all Laravel caches (config, route, view, event, cache)
- **Optimize** - Caches config, routes, views, and events for better performance
- **Restart** - Full restart: clears all caches and re-optimizes

### Database
- **Migrate** - Run pending database migrations
- **Seed** - Seed the database with test data
- **Fresh Install** - Drop all tables, run migrations, and seed (⚠️ destroys data)

### Development
- **Storage Link** - Create symbolic link for public storage
- **View Logs** - Display the last 50 lines of Laravel logs
- **Run Tests** - Execute PHPUnit tests
- **Start Server** - Start Laravel development server (localhost:8000)
- **Watch Assets** - Run Vite in development mode with hot reload

### Composer & NPM
- **Composer Install** - Install PHP dependencies
- **Composer Update** - Update PHP dependencies
- **NPM Install** - Install JavaScript dependencies
- **NPM Build** - Build assets for production

### Other
- **Generate APP_KEY** - Generate a new application key
- **List Routes** - Display all registered routes
- **Queue Worker** - Start the queue worker

## Usage Examples

### Daily Development Workflow
```bash
# Start your day
bash dev.sh              # Open menu and select options

# Or quick commands
dev clear                # Clear caches
dev migrate              # Run new migrations
dev serve                # Start server
```

### After Pulling Changes
```bash
dev restart              # Clear caches and optimize
dev migrate              # Run new migrations
```

### Fresh Setup
```bash
composer install
npm install
cp .env.example .env
dev restart
bash scripts/storage-link.sh
dev fresh                # Migrate and seed
```

### Performance Optimization (Production)
```bash
dev optimize             # Cache everything
npm run build            # Build assets
```

## Tips

1. **Use the interactive menu** (`bash dev.sh`) when you're not sure which command to use
2. **Use quick commands** (`dev [command]`) when you know exactly what you need
3. **Run `dev restart`** after changing config files or routes
4. **Run `dev clear`** if something seems cached incorrectly
5. **Run `dev optimize`** before deploying to production

## Customization

You can edit the scripts in the `scripts/` directory or modify `dev.sh` to add your own shortcuts. All scripts are simple bash scripts that run Laravel Artisan commands.
