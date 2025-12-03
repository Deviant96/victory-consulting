# Notification Setup Guide

## Overview
This guide explains how to configure email and push notifications for the booking system.

## ✅ What Has Been Fixed

### 1. Checkbox UI
- Fixed toggle switch styling using proper Tailwind CSS classes
- Removed custom CSS in favor of Tailwind's `peer` modifier utilities
- Toggles now display correctly with proper animations

### 2. Validation Issues
- Fixed validation in `SettingController` to properly handle nested array values from the form
- Changed from strict boolean validation to flexible casting
- Settings now save correctly when toggling switches

### 3. Service Worker Route
- Added route to serve `/service-worker.js` with correct `Content-Type` header
- Push notifications can now register the service worker properly

### 4. Mail Configuration
- Updated `.env` with SMTP configuration ready for Gmail
- Added instructions for setting up Gmail App Password

---

## 📧 Email Notification Setup

### Step 1: Configure Gmail SMTP (Recommended for Testing)

1. **Enable 2-Factor Authentication** on your Google Account
   - Go to: https://myaccount.google.com/security

2. **Generate an App Password**
   - Visit: https://myaccount.google.com/apppasswords
   - Select "Mail" as the app and "Other" as the device
   - Copy the generated 16-character password

3. **Update `.env` file**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-16-char-app-password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="your-email@gmail.com"
   MAIL_FROM_NAME="${APP_NAME}"
   ```

4. **Clear config cache**
   ```bash
   php artisan config:clear
   ```

### Alternative: Use Other Mail Services

#### Mailgun
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.mailgun.org
MAILGUN_SECRET=your-mailgun-api-key
```

#### Amazon SES
```env
MAIL_MAILER=ses
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=us-east-1
```

#### Mailtrap (Development/Testing)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
```

### Testing Email Notifications

1. Go to: **Admin > Settings > Booking Notifications**
2. Enable "Email notification"
3. Enter a notification email address
4. Save settings
5. Submit a test booking from the frontend
6. Check the configured email inbox

---

## 🔔 Push Notification Setup

### Prerequisites
✅ WebPush packages already installed:
- `laravel-notification-channels/webpush`
- `minishlink/web-push`

✅ VAPID keys already configured in `.env`:
```env
VAPID_PUBLIC_KEY=BCkW55slUQxe2YuhfM3AP8D8p-VzX9l49X1ccfPW3kOTV8W7tmiWBUV5BqFWm8ZrTUxjk5pMnhc8xANp_mSuFhs
VAPID_PRIVATE_KEY=cTW2GULdA_50YV7m0bMzZ_7BB8AyLHN6mp-4PdFGiY4
VAPID_SUBJECT=mailto:mcrealdeviant@gmail.com
```

### How to Use Push Notifications

1. **Enable in Settings**
   - Go to: **Admin > Settings > Booking Notifications**
   - Toggle "Push notification" to ON
   - Click "Save preferences"

2. **Subscribe to Push Alerts**
   - Click the "Subscribe to push alerts" button
   - Allow notifications when prompted by your browser
   - You should see "Subscribed! You will get push alerts for new bookings."

3. **Test the Notification**
   - Submit a booking from the frontend
   - You should receive a browser notification
   - Clicking the notification opens the booking details

### Browser Support

Push notifications work on:
- ✅ Chrome/Edge (Desktop & Android)
- ✅ Firefox (Desktop & Android)
- ✅ Safari 16+ (macOS & iOS)
- ✅ Opera (Desktop & Android)

### Troubleshooting Push Notifications

#### Issue: "Push not supported in this browser"
**Solution**: Use Chrome, Firefox, Edge, or Safari 16+

#### Issue: "Permission was denied"
**Solution**: 
1. Check browser notification settings
2. Reset permissions for the site
3. Try again

#### Issue: "Could not subscribe"
**Solutions**:
1. Ensure you're logged in as an admin user
2. Check browser console for detailed errors
3. Verify service worker is registered:
   - Open DevTools > Application > Service Workers
   - Should see `/service-worker.js` registered

#### Issue: Notifications not appearing
**Solutions**:
1. Check if "Push notification" is enabled in settings
2. Verify you clicked "Subscribe to push alerts"
3. Check browser notification permissions
4. Look for errors in `storage/logs/laravel.log`

---

## 🔍 Queue Configuration (Optional but Recommended)

For production, notifications should be queued to avoid blocking requests:

1. **Set queue connection in `.env`**
   ```env
   QUEUE_CONNECTION=database
   ```

2. **Run queue worker**
   ```bash
   php artisan queue:work
   ```

3. **For production, use Supervisor**
   ```ini
   [program:victory-queue]
   command=php /var/www/html/victory-consulting/artisan queue:work --sleep=3 --tries=3
   autostart=true
   autorestart=true
   user=www-data
   redirect_stderr=true
   stdout_logfile=/var/www/html/victory-consulting/storage/logs/queue.log
   ```

---

## 🧪 Testing Checklist

### Email Notifications
- [ ] SMTP credentials configured in `.env`
- [ ] Config cache cleared
- [ ] Email toggle enabled in settings
- [ ] Notification email address set
- [ ] Test booking submitted
- [ ] Email received in inbox

### Push Notifications
- [ ] VAPID keys in `.env`
- [ ] Push toggle enabled in settings
- [ ] Subscribed to push alerts as admin user
- [ ] Test booking submitted
- [ ] Push notification appeared in browser
- [ ] Clicking notification opens correct page

---

## 📝 Additional Notes

### Security
- Never commit `.env` file with real credentials
- Use environment-specific configuration
- Rotate VAPID keys if compromised

### Performance
- Use queue workers for production
- Monitor `storage/logs/laravel.log` for errors
- Set up retry logic for failed notifications

### Debugging
- Enable debug mode: `APP_DEBUG=true`
- Check logs: `tail -f storage/logs/laravel.log`
- Use Laravel Telescope for detailed monitoring

---

## 🆘 Support

If you encounter issues:
1. Check `storage/logs/laravel.log` for error messages
2. Verify all configuration values in `.env`
3. Clear cache: `php artisan config:clear && php artisan cache:clear`
4. Restart queue workers if using queues
5. Check browser console for JavaScript errors
