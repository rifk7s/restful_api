# RESTful API Perpustakaan

RESTful API for Library Information System built with Laravel 12. Provides CRUD operations for Books and Members.

## Tech Stack

- Laravel 12.38.1
- PHP 8.4.14
- SQLite Database
- Pest 4 for testing

<!-- ## Features

- **RESTful API Design** - Follows REST principles with proper HTTP methods and status codes
- **JSON Response Enforcement** - `ForceJsonResponse` middleware ensures all API endpoints return JSON responses
- **Request Validation** - Form Request classes validate all incoming data with custom error messages
- **API Resources** - Consistent JSON response structure using Laravel API Resources
- **Comprehensive Testing** - Feature tests covering all CRUD operations and edge cases
- **Database Factories** - Easy data generation for testing and seeding -->

## Project Structure

```
app/
├── Http/
│   ├── Controllers/Api/V1/
│   │   ├── BookController.php
│   │   └── MemberController.php
│   ├── Middleware/
│   │   └── ForceJsonResponse.php
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

All endpoints are prefixed with `/api`

**Books:**
- GET    `/api/books` - List all books
- POST   `/api/books` - Create new book
- GET    `/api/books/{id}` - Get specific book
- PATCH  `/api/books/{id}` - Update book
- DELETE `/api/books/{id}` - Delete book

**Members:**
- GET    `/api/members` - List all members
- POST   `/api/members` - Create new member
- GET    `/api/members/{id}` - Get specific member
- PATCH  `/api/members/{id}` - Update member
- DELETE `/api/members/{id}` - Delete member
<!-- 
### Status Codes

| Endpoint | Method | Success | Error |
|----------|--------|---------|-------|
| `/api/books` | POST | `201 Created` | `422 Unprocessable Entity` (validation) |
| `/api/books` | GET | `200 OK` | - |
| `/api/books/{id}` | GET | `200 OK` | `404 Not Found` |
| `/api/books/{id}` | PATCH | `200 OK` | `404 Not Found`, `422 Unprocessable Entity` |
| `/api/books/{id}` | DELETE | `204 No Content` | `404 Not Found` |
| `/api/members` | POST | `201 Created` | `422 Unprocessable Entity` (validation) |
| `/api/members` | GET | `200 OK` | - |
| `/api/members/{id}` | GET | `200 OK` | `404 Not Found` |
| `/api/members/{id}` | PATCH | `200 OK` | `404 Not Found`, `422 Unprocessable Entity` |
| `/api/members/{id}` | DELETE | `204 No Content` | `404 Not Found` | -->

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
- stock (integer, default: 0)
- created_at, updated_at (timestamps)

**members table:**
- id (primary key)
- student_id (string, unique, required)
- name (string, required)
- email (string, unique, required)
- created_at, updated_at (timestamps)

## Validation Rules

**Books:**
- title: required, max 255 chars
- author: required, max 255 chars
- isbn: required, unique
- published_year: required, integer, min 1000, max (current year + 1)
- stock: optional, integer, min 0

**Members:**
- student_id: required, unique
- name: required, max 255 chars
- email: required, valid email, unique

## Test Coverage

- 20 feature tests covering all CRUD operations
- 104 assertions validating functionality
- All tests passing
- Coverage includes validation, error handling, and edge cases

## API Documentation

- **API Documentation**: Complete API reference with examples → [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
- **Test Screenshots**: Postman test results for all endpoints → [SCREENSHOTS.md](SCREENSHOTS.md)


