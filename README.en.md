# Kampung Budiman Community Sports Participant Registration System

This is a participant registration system for the Kampung Budiman Sukan Rakyat / Sukan SULAM event. Public participants can register through a QR-code-accessible link without logging in, receive a unique registration code, and check their registration status. Participants cannot edit their own submitted details; any correction must be handled by the admin.

## Tech Stack

- Laravel 12
- PHP 8.2+
- MySQL/MariaDB for production
- SQLite for local development if preferred
- Blade templates
- Tailwind CSS
- Flowbite
- Vite
- Laravel Breeze authentication

## Installation

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

## `.env` Setup

For MySQL/MariaDB:

```env
APP_NAME="Sukan Budiman"
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sukan_budiman
DB_USERNAME=root
DB_PASSWORD=
```

For local SQLite:

```env
DB_CONNECTION=sqlite
```

If using SQLite, make sure `database/database.sqlite` exists.

## Database Setup

```bash
php artisan migrate:fresh --seed
```

The seeders create:

- Default admin user
- Sample sports houses
- Initial Sukan SULAM sports/events

## Default Admin Login

- Email: `admin@budiman.test`
- Password: `password`

Change this password before using the system in a real event.

## Run Locally

```bash
npm run dev
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

For production asset build:

```bash
npm run build
```

## Public Routes

- `/` - Landing page
- `/daftar` - Participant registration form
- `/berjaya/{registration_code}` - Registration success page
- `/semak` - Check registration page
- `/status/{registration_code}` - Registration status page

## Admin Routes

- `/login` - Admin login
- `/admin/dashboard` - Admin dashboard
- `/admin/participants` - Participant management
- `/admin/houses` - Sports house management
- `/admin/sports` - Sports/event management
- `/admin/reports` - Reports and CSV export
- `/admin/reports/print` - Print-friendly participant list
- `/admin/audit-logs` - Admin audit log
- `/admin/settings` - Registration and event settings

## Main Features

- Public participant registration without login
- Unique registration code generation
- Public users cannot edit submitted details
- Guardian details required for child participants
- Participant category is calculated automatically from age: below 12 is `Kanak-Kanak`, 12 and above is `Dewasa`
- `Terbuka` events can be selected by both child and adult participants
- Admin can add, view, edit, and delete participant records
- Admin can manage sports houses
- Admin can manage sports/events
- Admin can assign participants to sports/events
- CSV export for participant records
- Print-friendly participant lists
- Simple WhatsApp reminder link
- Audit logging for admin create, update, and delete actions
- Registration open/close settings, deadline, event date, event time, venue, and admin contact
- Event capacity handling with `Diterima` and `Senarai Menunggu` statuses
- Admin login is not linked from public pages; admins can open `/login` directly

## Testing

```bash
php artisan test
```

## Current Limitations

- No paid SMS or WhatsApp API integration.
- Full role management with Spatie Laravel Permission is not installed because the current version only needs a basic admin user.
- The system does not generate PDFs automatically; printing is handled through print-friendly browser pages.

## Future Improvements

- QR code generator for the `/daftar` registration link.
- Additional roles such as registration crew or event coordinator.
