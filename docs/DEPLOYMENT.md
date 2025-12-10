# Deployment Guide for Subdirectory Installation

This application is configured to work in a subdirectory (`/victory-consulting/`).

## Production Environment Configuration

### 1. Environment Variables

Update your production `.env` file with these exact values:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://miretazam.cloud/victory-consulting
ASSET_URL=https://miretazam.cloud/victory-consulting
```

### 2. Web Server Configuration

#### Apache (.htaccess)
The `.htaccess` file is already configured for subdirectory deployment.

Make sure Apache has `mod_rewrite` enabled:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Document Root
Your web server document root should point to:
```
/var/www/html/victory-consulting/public
```

Or if the root is `/var/www/html`, ensure the application is in:
```
/var/www/html/victory-consulting/
```

### 3. File Permissions

Set proper permissions:
```bash
sudo chown -R www-data:www-data /var/www/html/victory-consulting
sudo chmod -R 755 /var/www/html/victory-consulting
sudo chmod -R 775 /var/www/html/victory-consulting/storage
sudo chmod -R 775 /var/www/html/victory-consulting/bootstrap/cache
```

### 4. Clear and Cache Configuration

After deployment, run:
```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear

# Then optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. Verify Livewire Assets

The Livewire JavaScript should be accessible at:
```
https://miretazam.cloud/victory-consulting/livewire/livewire.js
```

If you get a 404 or 405 error, ensure:
- Routes are properly cached (`php artisan route:cache`)
- `.htaccess` is being processed by Apache
- `APP_URL` and `ASSET_URL` are correctly set in `.env`

## Testing

1. Access your site: `https://miretazam.cloud/victory-consulting/`
2. Check browser console for any JavaScript errors
3. Verify Livewire components are working correctly

## Troubleshooting

### Issue: Livewire assets return 404/405
- Clear all caches: `php artisan optimize:clear`
- Verify environment variables are loaded: `php artisan config:show app`
- Check `.htaccess` is being processed: Add a syntax error temporarily to see if it causes a 500 error

### Issue: CSS/JS assets not loading
- Verify `ASSET_URL` is set in `.env`
- Run `php artisan config:cache`
- Check if `public/build` directory exists with compiled assets

### Issue: Routes not working
- Ensure `RewriteBase /victory-consulting/` is in `.htaccess`
- Verify Apache `AllowOverride All` is set for the directory
- Clear route cache: `php artisan route:clear && php artisan route:cache`
