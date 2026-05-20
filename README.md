# Online Lost and Found Reporting System

A full-stack **Laravel 11** web application for reporting lost/found items, smart matching, secure messaging, and admin moderation. Built with **PHP, MySQL/SQLite, Blade, Tailwind CSS**, and optional **AJAX** live search.

## Features

- User authentication (Laravel Breeze): register, login, logout, forgot password, profile
- Lost & found item reports with multiple image uploads
- Search & filter (keyword, category, location, date, status) + AJAX live search
- Smart match notifications (category, keywords, location similarity) via email + in-app
- Comments, secure contact requests, bookmarks
- Status tracking: Lost, Found, Matched, Returned, Closed
- Admin panel: users, reports, categories, analytics
- QR verification codes, PDF export, dark mode, map coordinate picker
- RESTful **API v1** routes for future mobile apps

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 11, PHP 8.2+ |
| Frontend | Blade, Tailwind CSS, Alpine.js |
| Database | MySQL (production) / SQLite (local demo) |
| Auth | Laravel Breeze |
| Extras | DomPDF, Simple QrCode |

## Requirements

- PHP >= 8.2 with extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- Composer
- Node.js & npm
- MySQL 8+ (recommended for production)

## Installation

```bash
# 1. Clone or enter project directory
cd devopstry

# 2. Install PHP dependencies
composer install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Configure database (.env)
# SQLite (quick local demo):
DB_CONNECTION=sqlite
# Create file: type nul > database\database.sqlite   (Windows)
# touch database/database.sqlite                     (Mac/Linux)

# MySQL (production):
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=lost_found
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 5. Mail (local: logs to storage/logs/laravel.log)
MAIL_MAILER=log

# 6. Run migrations & seed demo data
php artisan migrate --seed

# 7. Storage symlink (image uploads)
php artisan storage:link

# 8. Frontend assets
npm install
npm run build

# 9. Start development server
php artisan serve
```

Visit: **http://127.0.0.1:8000**

## Demo Accounts

| Role | Email | Password |
|------|-------|------------|
| Admin | admin@lostfound.test | password |
| User | user@lostfound.test | password |

## Project Structure

```
app/
├── Enums/              # ItemStatus, ContactPreference, MessageStatus
├── Events/             # ItemMatchDetected
├── Http/
│   ├── Controllers/    # Web, Admin, Api
│   ├── Middleware/     # Admin, NotBlocked
│   ├── Requests/       # Form validation
│   └── Resources/      # API JSON resources
├── Listeners/          # Match notification listener
├── Models/             # Eloquent models & relationships
├── Notifications/      # ItemMatchFoundNotification
├── Policies/           # Authorization
└── Services/           # Match, Search, Upload, Report services
database/migrations/    # Schema
database/seeders/       # Categories + demo data
resources/views/        # Blade UI
routes/web.php          # Web routes
routes/api.php          # API v1 routes
```

## API Endpoints (v1)

Base URL: `/api/v1`

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/categories` | List active categories |
| GET | `/lost-items` | Search lost items (query params: q, category_id, location, date_from, date_to) |
| GET | `/lost-items/{slug}` | Lost item details |
| GET | `/found-items` | Search found items |
| GET | `/found-items/{slug}` | Found item details |

## Useful Commands

```bash
php artisan migrate:fresh --seed   # Reset DB with demo data
php artisan test                   # Run tests
php artisan route:list             # List all routes
php artisan queue:work             # If using queued notifications
composer run dev                   # Concurrent dev server + vite + queue
```

## Security

- CSRF protection on all forms
- Form Request validation & authorization policies
- Rate limiting on contact, comments, messages
- Secure image validation (type/size)
- Blocked users middleware
- Admin-only routes

## License

MIT — built for educational and production-ready demonstration purposes.
