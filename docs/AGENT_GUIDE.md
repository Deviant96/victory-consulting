# AI Agent Guide

How AI tools should contribute to Victory CMS safely and correctly.

---

## 1. Primary Rules

1. Always use Laravel 10/11 conventions.
2. Always follow the project's migrations, models, and structure.
3. Never propose WordPress, plugins, or unrelated frameworks.
4. Output full file examples when generating code.
5. Keep admin UI in Tailwind + Blade + Alpine.

---

## 2. When Generating Code

Follow these patterns:

### Controllers
- Namespaced under `App\Http\Controllers\Admin`
- CRUD methods: `index`, `create`, `store`, `edit`, `update`, `destroy`
- Use Form Requests for validation

### Blade Templates
- Use components when possible
- Keep forms clean with Tailwind classes

### Models
- Add `fillable` or guarded fields
- Use relationships where appropriate

### Migrations
- Use Laravel naming conventions
- Include timestamps

---

## 3. Data Access

Use recommended helpers:

```php
settings('branding.logo');
settings()->set('branding.color_primary', '#112244');
```

Media uploads via:

```php
$model->addMediaFromRequest('photo')->toMediaCollection('photos');
```

---

## 4. Avoid These

- No inline SQL
- No dumping raw JSON in controllers
- No business logic inside Blade
- No exposing sensitive routes publicly

---

## 5. AI Response Format

When generating code:

- Provide filename
- Provide full contents
- Use correct namespaces
- No placeholder pseudo-code

**Example:**

```
File: app/Models/Service.php
```

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [...];
}
```

---

## 6. Scope of AI Assistance

### Allowed:
- Generating migrations
- Building CRUD controllers
- Writing Blade views
- Improving code
- Creating components
- Refactoring

### Not allowed:
- Changing core architecture without request
- Introducing exotic frameworks
- Removing fundamental modules

---

## 7. Final Guidance

- Keep it simple.
- Follow Laravel best practices.
- Match the tone and style used in the rest of the codebase.
