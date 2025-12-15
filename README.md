# Laravel Sail Docker Learning Project

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About This Project

This is a Laravel 12 application configured with Laravel Sail for Docker-based development. The project includes authentication scaffolding with Laravel Breeze, API capabilities with Laravel Sanctum, and a complete development environment setup using Docker containers.

### Features Included

- **Laravel 12**: Latest version of the Laravel framework
- **Laravel Sail**: Docker development environment for Laravel
- **Laravel Breeze**: Simple authentication scaffolding
- **Laravel Sanctum**: API token authentication for SPAs and mobile applications
- **MySQL Database**: Database service via Docker
- **Redis**: Caching and session store via Docker
- **Vite**: Modern asset bundling and hot reloading
- **Pest Testing**: Modern PHP testing framework
- **Admin User Management**: Seeded admin users for testing

### Technology Stack

- **Backend**: PHP 8.2, Laravel 12
- **Database**: MySQL 8.0
- **Caching**: Redis
- **Frontend Assets**: Vite with hot reloading
- **Testing**: Pest PHP
- **Development Environment**: Docker with Laravel Sail

## Prerequisites

Before setting up this project, ensure you have the following installed:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/downloads)

## Project Setup Instructions

### 1. Clone the Repository

```bash
git clone <your-repository-url>
cd laravel-sail-docker-learning
```

### 2. Install Dependencies

First, install Composer dependencies. If you don't have Composer installed locally, you can use Docker:

```bash
# If you have Composer installed locally
composer install

# OR using Docker (if Composer is not installed locally)
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

### 3. Environment Configuration

Copy the environment file and generate application key:

```bash
# Copy environment file
cp .env.example .env

# Generate application key using Sail
./vendor/bin/sail artisan key:generate
```

### 4. Configure Environment Variables

Edit the `.env` file with your preferred settings:

```env
APP_NAME="Laravel Sail Docker Learning"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_docker_learning
DB_USERNAME=sail
DB_PASSWORD=password

# Cache Configuration
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis Configuration
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 5. Start Development Environment

Start all Docker services using Laravel Sail:

```bash
# Start all services in the background
./vendor/bin/sail up -d

# OR start with logs visible
./vendor/bin/sail up
```

This will start the following services:
- **Laravel Application**: http://localhost
- **MySQL Database**: Available on port 3306
- **Redis**: Available on port 6379
- **Mailhog** (if configured): Available on port 8025

### 6. Database Setup

Run database migrations and seed data:

```bash
# Run database migrations
./vendor/bin/sail artisan migrate

# Seed the database with sample data
./vendor/bin/sail artisan db:seed

# OR combine both commands
./vendor/bin/sail artisan migrate --seed
```

### 7. Install Frontend Dependencies

Install NPM packages and build assets:

```bash
# Install NPM dependencies
./vendor/bin/sail npm install

# Build assets for development
./vendor/bin/sail npm run dev

# OR build for production
./vendor/bin/sail npm run build
```

## Development Workflow

### Using Laravel Sail Commands

Laravel Sail provides convenient wrapper commands for common tasks:

```bash
# Artisan commands
./vendor/bin/sail artisan make:controller UserController
./vendor/bin/sail artisan make:model Product -m

# Composer commands
./vendor/bin/sail composer require package-name
./vendor/bin/sail composer update

# NPM commands
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
./vendor/bin/sail npm run build

# Database operations
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail artisan db:seed --class=AdminUserSeeder

# Cache operations
./vendor/bin/sail artisan cache:clear
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan route:clear
```

### Creating a Sail Alias

For convenience, you can create a shell alias:

```bash
# Add to ~/.bashrc or ~/.zshrc
alias sail='[ -f vendor/bin/sail ] && vendor/bin/sail || docker run --rm -v $(pwd):/opt -w /opt laravelsail/php82-composer:latest vendor/bin/sail'

# Reload your shell configuration
source ~/.bashrc  # or source ~/.zshrc

# Now you can use sail directly
sail up -d
sail artisan migrate
sail npm run dev
```

### Running Tests

Execute the test suite using Pest:

```bash
# Run all tests
./vendor/bin/sail artisan test

# OR using Pest directly
./vendor/bin/sail pest

# Run specific test file
./vendor/bin/sail artisan test tests/Feature/ExampleTest.php

# Run tests with coverage
./vendor/bin/sail artisan test --coverage
```

## Database Information

### Migrations

The project includes the following migrations:

- `create_users_table` - User authentication table
- `create_cache_table` - Cache storage table
- `create_jobs_table` - Queue jobs table
- `create_personal_access_tokens_table` - Sanctum API tokens

### Seeders

Available database seeders:

- `DatabaseSeeder` - Main seeder that calls other seeders
- `AdminUserSeeder` - Creates admin users for testing

```bash
# Run specific seeder
./vendor/bin/sail artisan db:seed --class=AdminUserSeeder

# Run all seeders
./vendor/bin/sail artisan db:seed
```

## API Development

This project includes Laravel Sanctum for API authentication:

### API Routes

API routes are defined in `routes/api.php` and are automatically prefixed with `/api`.

### Authentication

- Use Sanctum tokens for API authentication
- Tokens can be created through the web interface or API endpoints
- Include tokens in Authorization header: `Bearer your-api-token`

## Production Deployment

### Building for Production

```bash
# Install production dependencies
./vendor/bin/sail composer install --optimize-autoloader --no-dev

# Build production assets
./vendor/bin/sail npm run build

# Cache configuration
./vendor/bin/sail artisan config:cache
./vendor/bin/sail artisan route:cache
./vendor/bin/sail artisan view:cache
```

### Environment Configuration

Update `.env` for production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Use production database credentials
DB_HOST=your-production-host
DB_DATABASE=your-production-database
DB_USERNAME=your-production-username
DB_PASSWORD=your-secure-password
```

## Stopping the Development Environment

```bash
# Stop all services
./vendor/bin/sail down

# Stop and remove volumes (this will delete database data)
./vendor/bin/sail down -v
```

## Troubleshooting

### Common Issues

1. **Port conflicts**: If port 80 is already in use, modify `docker-compose.yml` to use different ports
2. **Permission issues**: Run `sudo chown -R $USER:$USER .` to fix file permissions
3. **Database connection issues**: Ensure the `DB_HOST` in `.env` is set to `mysql` (not `localhost`)

### Useful Commands

```bash
# View running containers
docker ps

# View Sail logs
./vendor/bin/sail logs

# Access the application container
./vendor/bin/sail shell

# Access MySQL database
./vendor/bin/sail mysql

# Access Redis CLI
./vendor/bin/sail redis
```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing)
- [Powerful dependency injection container](https://laravel.com/docs/container)
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent)
- Database agnostic [schema migrations](https://laravel.com/docs/migrations)
- [Robust background job processing](https://laravel.com/docs/queues)
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting)

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Resources

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
