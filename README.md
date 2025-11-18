# RESTful API Perpustakaan

RESTful API for Library Information System built with Laravel 12. Provides CRUD operations for Books and Members.

## Tech Stack

- Laravel 12.38.1
- PHP 8.4.14
- SQLite Database
- Pest 4 for testing

## Project Structure

```
app/
├── Http/
│   ├── Controllers/Api/V1/
│   │   ├── BookController.php
│   │   └── MemberController.php
│   ├── Requests/
│   │   ├── StoreBookRequest.php
│   │   ├── UpdateBookRequest.php
│   │   ├── StoreMemberRequest.php
│   │   └── UpdateMemberRequest.php
│   └── Resources/
│       ├── BookResource.php
│       └── MemberResource.php
└── Models/
    ├── Book.php
    └── Member.php

database/
├── factories/
│   ├── BookFactory.php
│   └── MemberFactory.php
└── migrations/
    ├── 2025_11_18_023439_create_books_table.php
    └── 2025_11_18_023440_create_members_table.php

routes/
└── api.php

tests/Feature/Api/V1/
├── BookApiTest.php
└── MemberApiTest.php
```

## API Endpoints

All endpoints are prefixed with `/api/v1`

**Books:**
- GET    `/api/v1/books` - List all books
- POST   `/api/v1/books` - Create new book
- GET    `/api/v1/books/{id}` - Get specific book
- PUT    `/api/v1/books/{id}` - Update book
- DELETE `/api/v1/books/{id}` - Delete book

**Members:**
- GET    `/api/v1/members` - List all members
- POST   `/api/v1/members` - Create new member
- GET    `/api/v1/members/{id}` - Get specific member
- PUT    `/api/v1/members/{id}` - Update member
- DELETE `/api/v1/members/{id}` - Delete member

## Installation & Setup

```bash
# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Start development server
php artisan serve
```

## Development Commands

### Creating Resources

```bash
# Create migration
php artisan make:migration create_books_table

# Create model with factory and seeder
php artisan make:model Book --factory --seed

# Create API controller
php artisan make:controller Api/V1/BookController --api

# Create form request
php artisan make:request StoreBookRequest

# Create API resource
php artisan make:resource BookResource

# Create feature test
php artisan make:test --pest Api/V1/BookApiTest
```

### Database Management

```bash
# Run migrations
php artisan migrate

# Reset and re-run all migrations
php artisan migrate:fresh

# View database schema
php artisan db:show

# List all routes
php artisan route:list
```

### Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test --filter=BookApiTest

# Run with coverage
php artisan test --coverage
```

### Code Quality

```bash
# Format code with Laravel Pint
vendor/bin/pint

# Format specific files
vendor/bin/pint app/Models
```

## Database Schema

**books table:**
- id (primary key)
- title (string, required)
- author (string, required)
- isbn (string, unique, required)
- published_year (integer, required)
- available (boolean, default: true)
- created_at, updated_at (timestamps)

**members table:**
- id (primary key)
- name (string, required)
- email (string, unique, required)
- phone (string, required)
- member_since (date, required)
- created_at, updated_at (timestamps)

## Validation Rules

**Books:**
- title: required, max 255 chars
- author: required, max 255 chars
- isbn: required, unique
- published_year: required, integer, min 1000, max (current year + 1)
- available: optional, boolean

**Members:**
- name: required, max 255 chars
- email: required, valid email, unique
- phone: required, max 20 chars
- member_since: required, valid date

## Test Coverage

- 18 feature tests covering all CRUD operations
- 99 assertions validating functionality
- All tests passing
- Coverage includes validation, error handling, and edge cases

## API Documentation

Complete API documentation with Postman testing guide available in [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

## License

MIT License
