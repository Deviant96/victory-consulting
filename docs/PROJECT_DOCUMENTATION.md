# 📘 Victory CMS – Project Documentation

**A custom Laravel-based CMS for Victory Business Consulting**  
**Version:** 1.0  
**Maintainer:** Miretazam Ciptaprima

---

## 1. Overview

Victory CMS is a custom content management system built on Laravel. The system powers both:

- Public-facing corporate website
- Internal admin dashboard for content management

The CMS replaces WordPress to offer cleaner UX, predictable performance, high security, and future scalability (client portal, document center, calculators, etc).

---

## 2. High-Level Goals

### Business Goals

- Give Victory a modern corporate website
- Provide extremely easy content editing
- Maintain consistent brand integrity
- Support content types used in consulting industries (services, FAQs, articles, team)
- Build a long-term foundation for expansions

### Technical Goals

- Clean Laravel codebase
- Simple CRUD for all content
- Structured database schema
- Custom admin dashboard (not Laravel Nova, not WordPress)
- Blade + Tailwind for admin & frontend
- Optional Inertia/Vue for advanced interactions
- Media handling via Spatie or native uploads

### UX Goals for the Client

- Admin dashboard that feels like their own "Victory CMS"
- Zero confusion, zero exposure to deep technical menus
- No risk of layout breaking
- One place for all content and settings
- Smooth writing/editing workflow

---

## 3. Tech Stack

### Backend

- Laravel 10 or 11
- PHP 8.1+
- Laravel Breeze (Blade version)
- MySQL or MariaDB
- Spatie Media Library (optional but recommended)

### Frontend (Admin)

- Blade
- TailwindCSS
- Alpine.js  
  _(Later: migrate to Inertia + Vue if needed)_

### Frontend (Public)

- Blade
- TailwindCSS
- Reusable Blade components

### Deployment

- Laravel Forge / VPS / Docker
- Nginx
- GitHub Actions (optional for CI/CD)

---

## 4. Architecture Summary

### Two Main Route Groups

**`routes/admin.php`**  
Contains:
- Authentication-protected admin dashboard
- CRUD routes
- Settings routes

**`routes/web.php`**  
Contains:
- Public pages
- Blog
- Services
- Contact page

### File Structure Standards

```
app/
  Http/
    Controllers/
      Admin/
      Frontend/
  Models/
resources/
  views/
    admin/
      services/
      team/
      faqs/
      articles/
      settings/
      layouts/
      components/
    frontend/
      layouts/
      services/
      team/
      blog/
      components/
routes/
  admin.php
  web.php
database/
  migrations/
  seeders/
public/
  uploads/
```

---

## 5. Database Design

### Tables

#### `services`

- `id`
- `title`
- `slug`
- `summary`
- `description` (long text/HTML)
- `category_id` (nullable)
- `price_note`
- `featured_image`
- `published` (boolean)
- `created_at`
- `updated_at`

#### `service_highlights`

- `id`
- `service_id`
- `label`
- `order`

#### `team_members`

- `id`
- `name`
- `position`
- `bio`
- `photo`
- `expertise` (json)
- `created_at`
- `updated_at`

#### `faqs`

- `id`
- `question`
- `answer`
- `category`
- `order`
- `published`
- `created_at`
- `updated_at`

#### `blog_posts`

- `id`
- `title`
- `slug`
- `excerpt`
- `content`
- `featured_image`
- `category`
- `published`
- `created_at`
- `updated_at`

#### `settings`

- `id`
- `key`
- `value` (json or text)

**Keys example:**
- `site.phone`
- `site.email`
- `site.whatsapp`
- `site.address`
- `site.office_hours`
- `social.linkedin`
- `social.instagram`
- `branding.logo`
- `branding.color_primary`
- `branding.color_secondary`

---

## 6. Admin Dashboard Requirements

### Overview Page

A quick-access dashboard with cards:

- Services (count + "Manage")
- Team Members
- FAQs
- Articles
- Settings shortcuts

### Sidebar Navigation

```
Victory CMS
-----------
Dashboard
Content
    Services
    Team Members
    FAQs
    Articles
Settings
    Contact Info
    Social Links
    Office Info
    Branding
Account
    Profile
    Logout
```

### Design Principles

- Professional
- Minimal
- Tailwind-based
- Clear typography
- Card components
- No clutter
- No system-level Laravel menus
- Fully branded UI

---

## 7. Content Management Requirements

### A. Services Module

**Features:**
- List, search, filter
- Create/edit/delete
- Drag-and-drop highlights
- Featured image upload
- Published toggle
- SEO fields (optional)

### B. Team Module

**Features:**
- List, create/edit/delete
- Photo upload
- Expertise tags (json array)

### C. FAQs Module

**Features:**
- List
- Category filter
- Order drag-and-drop
- Published toggle
- Simple form: Question + Answer

### D. Articles Module

**Features:**
- Basic WYSIWYG editor (Trix or TipTap)
- Feature image upload
- Category
- Published toggle

---

## 8. Settings System

Stored in the `settings` table.

**Sections include:**

### 1. Contact Info
- Phone
- Email
- WhatsApp link
- Office hours

### 2. Social Links
- LinkedIn
- Instagram
- YouTube
- TikTok

### 3. Office Info
- Address
- Google Map embed

### 4. Branding
- Logo upload
- Primary & secondary brand colors

**Helper:**
```php
settings('site.phone');
settings()->set('site.phone', '+62...');
```

---

## 9. Public Site Requirements

### Pages to Implement

- Home Page
- Services List
- Service Detail Page
- Team Page
- Blog List
- Blog Detail
- Contact Page
- FAQ Page (optional for public)

### Component-Driven Layout

**Reusable components:**
```blade
<x-service-card />
<x-team-card />
<x-faq-accordion />
```

**Content pulled dynamically:**
```php
Service::published()->get();
TeamMember::all();
BlogPost::where('published', 1)->paginate(10);
```

### Branding Applied via Settings

Logo and colors are dynamic.

---

## 10. Permissions & Roles

**Default roles:**
- `admin`: full access
- `editor`: CRUD on all content
- `writer`: articles only
- `viewer`: read-only (optional)

Use Laravel Gates or Spatie Permissions package.

---

## 11. Development Roadmap

### Phase 1 – Setup
- Initialize Laravel project
- Install Breeze
- Build admin layout
- Configure routing (web + admin)

### Phase 2 – Database & Models
- Create all migrations
- Implement relationships
- Seed minimal demo data

### Phase 3 – Admin CRUD
Build in this order:
1. Services
2. Team
3. FAQ
4. Articles
5. Settings

### Phase 4 – Public Frontend
- Build layouts
- Build pages
- Wire with database

### Phase 5 – Media System
- Implement Spatie Media Library
- Add thumbnails & resizing

### Phase 6 – Polish
- Form validation
- Flash messages
- Responsive UI
- Editor enhancements

### Phase 7 – Deployment
- VPS/Forge setup
- SSL
- Env configs
- Storage link
- Build assets

### Phase 8 – Handover
- Create user roles
- Provide documentation
- Train client

---

## 12. AI Agent Instructions

If an AI assistant generates code or logic for this project, it must follow these guidelines:

### AI Agent Rules

- Do not propose using WordPress or non-Laravel systems.
- Follow the database schema exactly.
- Follow the directory structure provided.
- CRUD controllers must:
  - Use Form Requests for validation
  - Return Blade views
  - Use redirect-based flash messages
- Admin UI must use Tailwind + Blade + Alpine.
- Media uploads must use:
  - Spatie Media Library, or
  - Native Laravel file upload
- Frontend pages must use Blade components and dynamic data.
- All settings changes must go through `settings()` helper.
- No exposing internal Laravel routes to the public.
- Always respect the admin vs public separation.

### AI Agent Output Format

**When generating code:**
- Provide full files, not fragments.
- Use correct namespaces.
- Follow Laravel naming conventions.
- Avoid unnecessary abstractions.
- Keep code readable and maintainable.

**When generating UI:**
- Use clean Tailwind classes.
- Use layout inheritance (`@extends`).
- Keep components reusable.

---

## 13. Future-Proofing (Phase 2 After Launch)

Potential expansions already supported by architecture:

- Client Portal (logins for clients)
- Document center (PDF uploads)
- Appointment booking
- Custom calculators (tax, payroll, BPJS)
- CRM-lite (leads, inquiries)
- Multi-language content
- Email automation
- REST API for external tools

The entire system is designed with scalability in mind.

---

## 14. Developer Notes

### Required Skills

- Laravel MVC
- Blade
- TailwindCSS
- Basic Alpine.js
- MySQL
- Linux deployment

### Coding Guidelines

- Follow PSR-12
- Keep controllers thin
- Move logic to service classes if needed
- Use Blade components
- Keep migrations small and readable
- Use env variables for URLs and credentials
