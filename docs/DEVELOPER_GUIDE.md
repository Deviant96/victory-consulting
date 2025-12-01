# Developer Guide

Minimal, practical guidance for working on Victory CMS.

---

## 1. Local Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run dev
php artisan serve
```

Admin dashboard: `/admin`  
Default auth is Breeze.

---

## 2. Project Layout

```
app/
  Models/
  Http/Controllers/Admin/
  Http/Controllers/Frontend/
resources/views/
  admin/
  frontend/
routes/
  admin.php
  web.php
database/migrations/
```

Admin and web routes are isolated for clarity.

---

## 3. CRUD Modules

Each module follows the same pattern:

- Model
- Migration
- Admin controller
- Blade views (index, create, edit)
- Optional service class (if logic grows)

**Modules:**
- Service
- TeamMember
- Faq
- BlogPost

If you need a new one, copy an existing module.

---

## 4. Settings System

Stored in `settings` table (key → value).

Use helper:

```php
settings('site.phone');
settings()->set('site.phone', '+62...');
```

Settings pages are in `/admin/settings/*`.

---

## 5. Media Handling

Using Spatie Media Library:

```php
$model->addMedia($request->file('image'))->toMediaCollection('featured');
```

Keep file sizes small for performance.

---

## 6. Frontend Pages

Frontend uses Blade templates under `resources/views/frontend/`.

Reusable components go into:

```
resources/views/frontend/components/
```

Each Blade template pulls structured data from models:

```php
$services = Service::published()->get();
return view('frontend.services.index', compact('services'));
```

---

## 7. Adding a New Module (Fast Guide)

1. Create migration
2. Create model
3. Add routes in `admin.php`
4. Build controller
5. Build Blade views
6. Add sidebar item
7. Update README/docs if needed

---

## 8. Deployment Checklist

Before pushing to production:

1. Run `php artisan migrate --force`
2. Run `npm run build`
3. Run `php artisan storage:link`
4. Verify uploaded images
5. Clear caches:
   ```bash
   php artisan optimize:clear
   ```

---

## 9. Troubleshooting

**Admin assets not loading:**  
Run `npm run dev` again.

**Images not showing:**  
Run `php artisan storage:link`.

**Login loop:**  
Check `SESSION_DOMAIN` in `.env`.

---

## 10. Contact

If you get stuck, refer to:
- Architecture.md
- Agent Guide (for code generation help)
- Ask the maintainer
