# Victory CMS Architecture

Minimal, practical overview of how this system is structured.

---

## 1. System Overview

Victory CMS is a custom Laravel application with two faces:

- **Public website**, built with Blade components
- **Admin dashboard**, built with Blade + Tailwind + Alpine

No external CMS, no plugins, no heavy frameworks.

---

## 2. Routing Structure

**`routes/web.php`**
- Public pages
- Services
- Blog
- Contact

**`routes/admin.php`**
- Dashboard
- CRUD modules
- Settings

Admin routes use `auth` middleware.

---

## 3. Key Modules

### Services
- title / summary / description
- featured image
- highlights (child table)
- published toggle

### Team Members
- name, position, bio
- expertise (json)
- photo

### FAQs
- question / answer
- category
- order
- published

### Articles
- title, excerpt, content
- featured image
- category
- published

### Settings
Key-value pairs for:
- Contact info
- Social links
- Office info
- Branding colors
- Logo

---

## 4. Views Architecture

```
resources/views/
  admin/
    services/
    team/
    faqs/
    articles/
    settings/
    layouts/
  frontend/
    services/
    team/
    blog/
    layouts/
```

Use components for repeated UI blocks.

---

## 5. Media System

Spatie Media Library recommended.

**Collections:**
- `services`
- `team_photos`
- `blog_images`
- `branding`

---

## 6. Frontend Rendering

Simple Blade pages:

- Homepage
- Services list
- Service detail
- Team page
- Blog list/detail

Each page pulls structured data from models.

---

## 7. Permissions

Default roles (optional):
- admin
- editor
- writer

---

## 8. Deployment Architecture

One web app:

- Nginx
- PHP-FPM
- MySQL
- Node build for Tailwind
- Laravel queue (if needed)

**Build steps:**

```bash
composer install
npm ci && npm run build
php artisan migrate --force
php artisan optimize
```

---

## 9. Future Extensions

System is prepared for:

- Client portal
- Document center
- Booking system
- Lead management
- Multi-language content
- REST API
