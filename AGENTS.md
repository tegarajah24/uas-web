# SIMRS — Agent Guide

**Stack**: Laravel 13 · Livewire 3 + Volt 1.7 · Tailwind CSS 4 · MySQL · Spatie Permission

---

# PART 1: BEHAVIOR & PROCESS RULES

## Mandatory Change Review Process
Whenever the user requests a modification, feature addition, refactor, deletion, optimization, or architecture change:
**DO NOT directly write or modify code.** Always respond using the following structure first:

1. **Request Summary:** Explain your understanding of what the user wants.
2. **Current State Analysis:** Identify what currently exists and which files/modules are involved.
3. **Proposed Changes:** Describe the "Before" (current behavior) and "After" (expected behavior).
4. **Files Affected:** List all files that may be modified or newly created.
5. **Impact Analysis:** Explain the Functional, Technical, Database (migration), and UI impacts.
6. **Risks:** Identify potential risks (breaking features, route conflicts) and rate them (Low/Medium/High).
7. **Alternative Approaches:** If applicable, provide Option A vs Option B with Pros & Cons.
8. **Implementation Plan:** Provide a step-by-step plan (e.g., 1. Update route, 2. Update view).
9. **Confirmation Required:** Explicitly ask: *"Do you want me to proceed with implementation?"*

**CRITICAL:** Never generate or apply code before the user explicitly gives confirmation (e.g., "Proceed", "Apply changes", "Write the code").

## Architecture Protection Rules
Do NOT perform the following actions without explicit explanation and user approval:
- Rename or delete folders, controllers, or routes.
- Change the database schema or migration files.
- Alter the authentication flow or core layout structure.
Prefer minimal, scoped, and safe changes over large refactors.

## Communication Style
Be concise, highly technical, yet supportive. Always review and analyze risks first. Implementation comes ONLY after user approval.

---

# PART 2: TECH STACK & CONTEXT

## Setup & Commands

| Command | What it does |
|---|---|
| `composer run setup` | Full install: `composer install` → copy `.env` → `key:generate` → `migrate` → `npm install` → `npm run build` |
| `composer run dev` | Concurrent dev: `artisan serve` + `queue:listen` + `pail` (logs) + `vite` dev server |
| `composer run test` | `config:clear` then `artisan test` (PHPUnit 12) |
| `npm run build` | `vite build` |
| `npm run dev` | Vite HMR only |
| `./vendor/bin/pint` | PHP code style fixer |

Use `composer run dev` not `artisan serve` alone. Tests use SQLite `:memory:`.

## Volt & Livewire

- **Volt functional components**: `resources/views/livewire/` and `resources/views/pages/` (see `VoltServiceProvider.php`)
- **Class Livewire components**: `app/Livewire/` (e.g. `Actions/Logout.php`, `Forms/LoginForm.php`)
- Both mount paths are active; pick one style per component.

## Tailwind 4

Config is in `resources/css/app.css`:
```css
@import 'tailwindcss';
```
No `tailwind.config.js`. No `@tailwind` directives. Theme via `@theme {}` block. Custom medical theme (biru/putih) defined via CSS variables in `@theme {}`.

## Routing & Page Conventions

- `routes/web.php` — Main application routing.
- `routes/auth.php` — Volt-based authentication routing.
- Auth pages use Livewire Volt located at `resources/views/livewire/pages/auth/`.

## Asset & Layout Conventions

- **Vite Entry Points:** `resources/css/app.css`, `resources/js/app.js`
- **Layouts:**
  - Standard App Layout: `layouts.app` (used by Breeze/Auth).

## Architecture

**4 modules** (specs in `docs/`):
1. **Front-Office** — patient registration + queue
2. **RME** (Rekam Medis Elektronik) — medical records
3. **Farmasi** — e-prescription + pharmacy stock
4. **Kasir** — billing/invoicing

Alur: Pendaftaran → RME → Farmasi → Kasir. Transisi status reaktif via Livewire events.

## Permissions

Spatie `laravel-permission` 8.1 installed. `User` model uses `HasRoles` trait. Roles: `admin_resepsionis`, `dokter`, `farmasi`, `kasir`.

## Database

- Local: `mysql` → `uas-web` (root, no password); SQLite for tests (`:memory:`)
- Session / Queue / Cache: all `database` driver
- Existing migrations: `users`, `cache`, `jobs`, `permission_tables`

## Style

- UI via pure Tailwind CSS 4 utility classes (no UI framework)
- Custom medical theme (biru/putih) defined in `resources/css/app.css` via `@theme {}`
- Layout uses CSS flex + sidebar toggle via Alpine.js
- Breeze auth scaffold present (login, register, password reset, profile)

## OpenCode MCP Integration

- ApexCharts docs are available via MCP (configured in `.opencode/opencode.json` or `.opencode.json`). Use keyword `apexcharts` when prompting for these specific components.
