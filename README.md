# TailAdmin Laravel Starter Kit

A modern Laravel starter kit with TailAdmin UI components, providing a complete authentication system and admin dashboard without the complexity of React, Vue, or Livewire.

![Profile Page](https://laraveldaily.com/uploads/2025/11/tailadmin-starter-kit-profile.png)

![Login Page](https://laraveldaily.com/uploads/2025/11/tailadmin-starter-kit-login.png)

## Features

- ✅ **Complete Authentication System** - Login, Register, Password Reset, Email Verification, Profile Management
- ✅ **Admin Dashboard** - Pre-built dashboard with user management
- ✅ **TailAdmin Components** - Beautiful UI components styled with Tailwind CSS
- ✅ **Blade Templates Only** - No React/Vue/Livewire required
- ✅ **Two-Level Menu** - Organized sidebar navigation
- ✅ **User Management** - CRUD operations for users with example table and forms
- ✅ **CI/CD Pipeline** - GitHub Actions workflow with automated testing and linting

![Users List](https://laraveldaily.com/uploads/2025/12/tailadmin-starter-kit-users-list.png)

![User Edit](https://laraveldaily.com/uploads/2025/12/tailadmin-starter-kit-user-edit.png)

---

## Tech Stack

### Backend

- **PHP** `^8.2` - Server-side scripting language
- **Laravel** `^12.0` - PHP web application framework
- **SQLite** - Default database (MySQL/PostgreSQL compatible)
- **Pest** `^4.5` - Modern PHP testing framework

### Frontend

- **Blade Templates** - Laravel's templating engine
- **Tailwind CSS** `^4.1.12` - Utility-first CSS framework
- **Alpine.js** `^3.14.9` - Lightweight JavaScript framework
- **Vite** `^7.0.4` - Frontend build tool

### UI Components & Libraries

- **ApexCharts** `^5.3.5` - Modern charting library
- **FullCalendar** `^6.1.19` - Interactive calendar
- **Flatpickr** `^4.6.13` - Lightweight date picker
- **Swiper** `^12.0.3` - Modern touch slider
- **Prism.js** `^1.30.0` - Syntax highlighter
- **jsvectormap** `^1.7.0` - Interactive vector maps

### Development Tools

- **Laravel Pint** `^1.24` - PHP code style fixer
- **Prettier** - JavaScript/CSS formatter
- **Laravel Sail** `^1.41` - Docker development environment
- **Laravel Pail** `^1.2.2` - Log viewer
- **Concurrently** `^9.0.1` - Run multiple commands simultaneously

---

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x
- **NPM** or **Yarn**
- **Git**
- **SQLite** (or MySQL/PostgreSQL if preferred)

### Check Your Environment

```bash
php -v
composer -v
node -v
npm -v
```

---

## Installation & Setup

### Method 1: Quick Install (New Project)

```bash
laravel new my-project --using=laraveldaily/tailadmin-starter-kit
cd my-project
npm install && npm run build
php artisan serve
```

### Method 2: Manual Setup (Existing/Cloned Project)

#### 1. Clone the Repository

```bash
git clone <repository-url>
cd testTailLaravel
```

#### 2. Install PHP Dependencies

```bash
composer install
```

#### 3. Install JavaScript Dependencies

```bash
npm install
```

#### 4. Environment Configuration

```bash
cp .env.example .env
```

Edit the `.env` file and configure your database settings:

**For SQLite (Default):**

```env
DB_CONNECTION=sqlite
```

**For MySQL:**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### 5. Generate Application Key

```bash
php artisan key:generate
```

#### 6. Create Database

**For SQLite:**

```bash
touch database/database.sqlite
```

**For MySQL:**

Create a database using your MySQL client:

```sql
CREATE DATABASE your_database_name;
```

#### 7. Run Database Migrations

```bash
php artisan migrate
```

#### 8. Build Frontend Assets

```bash
npm run build
```

#### 9. Start Development Server

**Option A: Simple Server**

```bash
php artisan serve
```

**Option B: Full Development Environment (Recommended)**

Run all services simultaneously (server, queue, logs, vite):

```bash
composer dev
```

This command runs:

- Laravel development server (http://localhost:8000)
- Queue worker
- Real-time log viewer (Pail)
- Vite dev server with HMR

#### 10. Access the Application

Open your browser and navigate to:

```
http://localhost:8000
```

---

## Development Workflow

### Run Development Server with Hot Reload

```bash
npm run dev
```

In a separate terminal:

```bash
php artisan serve
```

Or use the all-in-one command:

```bash
composer dev
```

### Run Tests

```bash
php artisan test
```

Or using Pest directly:

```bash
vendor/bin/pest
```

### Code Quality

**Check PHP Code Style:**

```bash
vendor/bin/pint --test
```

**Fix PHP Code Style:**

```bash
vendor/bin/pint
```

**Check JavaScript/CSS Formatting:**

```bash
npx prettier --check .
```

**Fix JavaScript/CSS Formatting:**

```bash
npx prettier --write .
```

### Database Operations

**Fresh Migration:**

```bash
php artisan migrate:fresh
```

**Seed Database:**

```bash
php artisan db:seed
```

**Fresh Migration with Seeding:**

```bash
php artisan migrate:fresh --seed
```

---

## Project Structure

```
├── app/
│   ├── Helpers/           # Helper functions (MenuHelper)
│   ├── Http/
│   │   ├── Controllers/   # Application controllers
│   │   └── Requests/      # Form request validation
│   └── Models/            # Eloquent models
├── database/
│   ├── migrations/        # Database migrations
│   ├── seeders/           # Database seeders
│   └── factories/         # Model factories
├── resources/
│   ├── css/               # CSS files
│   ├── js/                # JavaScript files
│   └── views/             # Blade templates
│       ├── auth/          # Authentication views
│       ├── components/    # Reusable components
│       ├── layouts/       # Layout templates
│       └── pages/         # Application pages
├── routes/
│   ├── web.php            # Web routes
│   └── auth.php           # Authentication routes
├── tests/
│   ├── Feature/           # Feature tests
│   └── Unit/              # Unit tests
└── public/                # Public assets
```

---

## Default Credentials

After running migrations and seeders, you can use these credentials (if configured in your seeders):

```
Email: admin@example.com
Password: password
```

_Note: Make sure to change these in production!_

---

## CI/CD Pipeline

The project includes a GitHub Actions workflow (`.github/workflows/ci.yml`) with three stages:

1. **Code Quality** - Runs Pint and Prettier
2. **Build** - Compiles frontend assets
3. **Tests** - Executes feature and unit tests with MySQL

The pipeline runs automatically on push/pull requests to `main` and `develop` branches.

---

## Customization

### Adding New Pages

1. Create a route in `routes/web.php`
2. Create a controller in `app/Http/Controllers`
3. Create a Blade view in `resources/views/pages`
4. Add menu items in `app/Helpers/MenuHelper.php`

### Modifying the Sidebar Menu

Edit the menu configuration in:

```
app/Helpers/MenuHelper.php
```

### Styling

All Tailwind CSS customizations can be done in:

```
resources/css/app.css
```

---

## Troubleshooting

### Permission Issues

```bash
chmod -R 775 storage bootstrap/cache
```

### Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Node Modules Issues

```bash
rm -rf node_modules package-lock.json
npm install
```

### Composer Issues

```bash
rm -rf vendor composer.lock
composer install
```

---

## Production Deployment

### 1. Optimize Application

```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Set Environment

Update `.env`:

```env
APP_ENV=production
APP_DEBUG=false
```

### 3. Set Proper Permissions

```bash
chmod -R 755 storage bootstrap/cache
```

---

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [TailAdmin Laravel Repository](https://github.com/TailAdmin/tailadmin-laravel)
- [TailAdmin Pro Version](https://checkout.tailadmin.com/buy/ed68b4bb-f0c6-4d20-a241-d3a5a81b0f25?aff=EEK4LN) - 500+ components and dashboard variants
- [LaravelDaily Starter Kit](https://github.com/LaravelDaily/starter-kit)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev/)

---

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

## Credits

This starter kit merges:

- [LaravelDaily/starter-kit](https://github.com/LaravelDaily/starter-kit)
- [TailAdmin Laravel](https://github.com/TailAdmin/tailadmin-laravel)

---

## Support

For issues and questions:

- Open an issue on GitHub
- Contact the maintainers

---

**Happy Coding! 🚀**
