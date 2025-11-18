# RESTful API Perpustakaan - API Documentation

## Table of Contents
1. [Overview](#overview)
2. [Base URL](#base-url)
3. [API Endpoints](#api-endpoints)
   - [Books API](#books-api)
   - [Members API](#members-api)
4. [HTTP Status Codes](#http-status-codes)
5. [Testing with Postman](#testing-with-postman)

---

## Overview

This is a RESTful API for a Library Information System (Sistem Informasi Perpustakaan Universitas) built with Laravel 12. The API provides complete CRUD operations for managing books and members.

**Features:**
- Full CRUD operations for Books and Members
- Comprehensive validation with custom error messages
- RESTful principles (proper HTTP methods and status codes)
- API versioning (v1)
- JSON responses
- Comprehensive test coverage with Pest

---

## Base URL

```
http://localhost:8000/api/v1
```

All API endpoints are prefixed with `/api/v1` for versioning.

---

## API Endpoints

### Books API

#### 1. Get All Books

**Endpoint:** `GET /api/v1/books`

**Description:** Retrieve a list of all books in the library.

**Request:**
```bash
GET http://localhost:8000/api/v1/books
```

**Response:** `200 OK`
```json
{
  "data": [
    {
      "id": 1,
      "title": "Laravel Mastery",
      "author": "John Doe",
      "isbn": "978-0123456789",
      "published_year": 2023,
      "available": true,
      "created_at": "2025-11-18T02:34:39.000000Z",
      "updated_at": "2025-11-18T02:34:39.000000Z"
    },
    {
      "id": 2,
      "title": "PHP Advanced",
      "author": "Jane Smith",
      "isbn": "978-9876543210",
      "published_year": 2022,
      "available": false,
      "created_at": "2025-11-18T02:35:00.000000Z",
      "updated_at": "2025-11-18T02:35:00.000000Z"
    }
  ]
}
```

---

#### 2. Create a New Book

**Endpoint:** `POST /api/v1/books`

**Description:** Add a new book to the library.

**Request:**
```bash
POST http://localhost:8000/api/v1/books
Content-Type: application/json

{
  "title": "Laravel Mastery",
  "author": "John Doe",
  "isbn": "978-0123456789",
  "published_year": 2023,
  "available": true
}
```

**Validation Rules:**
- `title`: required, string, max 255 characters
- `author`: required, string, max 255 characters
- `isbn`: required, string, unique
- `published_year`: required, integer, min 1000, max (current year + 1)
- `available`: optional, boolean (default: true)

**Response:** `201 Created`
```json
{
  "data": {
    "id": 1,
    "title": "Laravel Mastery",
    "author": "John Doe",
    "isbn": "978-0123456789",
    "published_year": 2023,
    "available": true,
    "created_at": "2025-11-18T02:34:39.000000Z",
    "updated_at": "2025-11-18T02:34:39.000000Z"
  }
}
```

**Error Response:** `422 Unprocessable Entity`
```json
{
  "message": "The title field is required. (and 1 more error)",
  "errors": {
    "title": [
      "Book title is required"
    ],
    "isbn": [
      "This ISBN already exists"
    ]
  }
}
```

---

#### 3. Get a Specific Book

**Endpoint:** `GET /api/v1/books/{id}`

**Description:** Retrieve details of a specific book by ID.

**Request:**
```bash
GET http://localhost:8000/api/v1/books/1
```

**Response:** `200 OK`
```json
{
  "data": {
    "id": 1,
    "title": "Laravel Mastery",
    "author": "John Doe",
    "isbn": "978-0123456789",
    "published_year": 2023,
    "available": true,
    "created_at": "2025-11-18T02:34:39.000000Z",
    "updated_at": "2025-11-18T02:34:39.000000Z"
  }
}
```

**Error Response:** `404 Not Found`
```json
{
  "message": "No query results for model [App\\Models\\Book] 999"
}
```

---

#### 4. Update a Book

**Endpoint:** `PUT /api/v1/books/{id}` or `PATCH /api/v1/books/{id}`

**Description:** Update book information. All fields are optional.

**Request:**
```bash
PUT http://localhost:8000/api/v1/books/1
Content-Type: application/json

{
  "title": "Laravel Mastery - Updated Edition",
  "available": false
}
```

**Validation Rules:**
- `title`: optional, string, max 255 characters
- `author`: optional, string, max 255 characters
- `isbn`: optional, string, unique (except current book)
- `published_year`: optional, integer, min 1000, max (current year + 1)
- `available`: optional, boolean

**Response:** `200 OK`
```json
{
  "data": {
    "id": 1,
    "title": "Laravel Mastery - Updated Edition",
    "author": "John Doe",
    "isbn": "978-0123456789",
    "published_year": 2023,
    "available": false,
    "created_at": "2025-11-18T02:34:39.000000Z",
    "updated_at": "2025-11-18T02:40:00.000000Z"
  }
}
```

---

#### 5. Delete a Book

**Endpoint:** `DELETE /api/v1/books/{id}`

**Description:** Remove a book from the library.

**Request:**
```bash
DELETE http://localhost:8000/api/v1/books/1
```

**Response:** `200 OK`
```json
{
  "message": "Book deleted successfully"
}
```

**Error Response:** `404 Not Found`
```json
{
  "message": "No query results for model [App\\Models\\Book] 999"
}
```

---

### Members API

#### 1. Get All Members

**Endpoint:** `GET /api/v1/members`

**Description:** Retrieve a list of all library members.

**Request:**
```bash
GET http://localhost:8000/api/v1/members
```

**Response:** `200 OK`
```json
{
  "data": [
    {
      "id": 1,
      "student_id": "STU12345",
      "name": "Alice Johnson",
      "email": "alice@example.com",
      "phone": "+1234567890",
      "member_since": "2023-01-15",
      "created_at": "2025-11-18T02:34:39.000000Z",
      "updated_at": "2025-11-18T02:34:39.000000Z"
    },
    {
      "id": 2,
      "student_id": "STU67890",
      "name": "Bob Smith",
      "email": "bob@example.com",
      "phone": "+0987654321",
      "member_since": "2023-02-20",
      "created_at": "2025-11-18T02:35:00.000000Z",
      "updated_at": "2025-11-18T02:35:00.000000Z"
    }
  ]
}
```

---

#### 2. Create a New Member

**Endpoint:** `POST /api/v1/members`

**Description:** Register a new library member.

**Request:**
```bash
POST http://localhost:8000/api/v1/members
Content-Type: application/json

{
  "student_id": "STU12345",
  "name": "Alice Johnson",
  "email": "alice@example.com",
  "phone": "+1234567890",
  "member_since": "2023-01-15"
}
```

**Validation Rules:**
- `student_id`: required, string, unique
- `name`: required, string, max 255 characters
- `email`: required, email format, unique
- `phone`: required, string, max 20 characters
- `member_since`: required, valid date

**Response:** `201 Created`
```json
{
  "data": {
    "id": 1,
    "student_id": "STU12345",
    "name": "Alice Johnson",
    "email": "alice@example.com",
    "phone": "+1234567890",
    "member_since": "2023-01-15",
    "created_at": "2025-11-18T02:34:39.000000Z",
    "updated_at": "2025-11-18T02:34:39.000000Z"
  }
}
```

**Error Response:** `422 Unprocessable Entity`
```json
{
  "message": "The student id field is required. (and 2 more errors)",
  "errors": {
    "student_id": [
      "Student ID is required",
      "This student ID is already registered"
    ],
    "email": [
      "Please provide a valid email address",
      "This email is already registered"
    ],
    "name": [
      "Member name is required"
    ]
  }
}
```

---

#### 3. Get a Specific Member

**Endpoint:** `GET /api/v1/members/{id}`

**Description:** Retrieve details of a specific member by ID.

**Request:**
```bash
GET http://localhost:8000/api/v1/members/1
```

**Response:** `200 OK`
```json
{
  "data": {
    "id": 1,
    "student_id": "STU12345",
    "name": "Alice Johnson",
    "email": "alice@example.com",
    "phone": "+1234567890",
    "member_since": "2023-01-15",
    "created_at": "2025-11-18T02:34:39.000000Z",
    "updated_at": "2025-11-18T02:34:39.000000Z"
  }
}
```

**Error Response:** `404 Not Found`
```json
{
  "message": "No query results for model [App\\Models\\Member] 999"
}
```

---

#### 4. Update a Member

**Endpoint:** `PUT /api/v1/members/{id}` or `PATCH /api/v1/members/{id}`

**Description:** Update member information. All fields are optional.

**Request:**
```bash
PUT http://localhost:8000/api/v1/members/1
Content-Type: application/json

{
  "name": "Alice Johnson Smith",
  "phone": "+1111111111"
}
```

**Validation Rules:**
- `student_id`: optional, string, unique (except current member) using Rule::unique()->ignore()
- `name`: optional, string, max 255 characters
- `email`: optional, email format, unique (except current member) using Rule::unique()->ignore()
- `phone`: optional, string, max 20 characters
- `member_since`: optional, valid date

**Response:** `200 OK`
```json
{
  "data": {
    "id": 1,
    "student_id": "STU12345",
    "name": "Alice Johnson Smith",
    "email": "alice@example.com",
    "phone": "+1111111111",
    "member_since": "2023-01-15",
    "created_at": "2025-11-18T02:34:39.000000Z",
    "updated_at": "2025-11-18T02:40:00.000000Z"
  }
}
```

---

#### 5. Delete a Member

**Endpoint:** `DELETE /api/v1/members/{id}`

**Description:** Remove a member from the library system.

**Request:**
```bash
DELETE http://localhost:8000/api/v1/members/1
```

**Response:** `200 OK`
```json
{
  "message": "Member deleted successfully"
}
```

**Error Response:** `404 Not Found`
```json
{
  "message": "No query results for model [App\\Models\\Member] 999"
}
```

---

## HTTP Status Codes

| Status Code | Meaning | Usage |
|-------------|---------|-------|
| 200 OK | Success | GET, PUT/PATCH, DELETE requests succeeded |
| 201 Created | Resource created | POST request successfully created a resource |
| 404 Not Found | Resource not found | Requested resource doesn't exist |
| 422 Unprocessable Entity | Validation failed | Request data failed validation rules |

---

## Testing with Postman

### Initial Setup

1. **Start Laravel Development Server:**
   ```bash
   php artisan serve
   ```
   Server will run at: `http://localhost:8000`

2. **Run Migrations (if not already done):**
   ```bash
   php artisan migrate
   ```

3. **Open Postman** and create a new collection called "Library API"

---

### Creating Requests in Postman

#### Collection Structure:
```
Library API
├── Books
│   ├── Get All Books
│   ├── Create Book
│   ├── Get Book by ID
│   ├── Update Book
│   └── Delete Book
└── Members
    ├── Get All Members
    ├── Create Member
    ├── Get Member by ID
    ├── Update Member
    └── Delete Member
```

---

### Step-by-Step Testing Guide

#### Test 1: Create a New Book

1. Create a new POST request
2. Set URL: `http://localhost:8000/api/v1/books`
3. Set Headers:
   - `Content-Type`: `application/json`
   - `Accept`: `application/json`
4. Set Body (raw JSON):
   ```json
   {
     "title": "Laravel 12: Complete Guide",
     "author": "Taylor Otwell",
     "isbn": "978-1234567890",
     "published_year": 2025,
     "available": true
   }
   ```
5. Click **Send**
6. **Expected Result:** 201 Created with book data

**Screenshot Checklist:**
- ✅ Status code: 201 Created
- ✅ Response contains all book fields
- ✅ `id` is generated automatically
- ✅ `created_at` and `updated_at` timestamps are present

---

#### Test 2: Get All Books

1. Create a new GET request
2. Set URL: `http://localhost:8000/api/v1/books`
3. Set Headers:
   - `Accept`: `application/json`
4. Click **Send**
5. **Expected Result:** 200 OK with array of books

**Screenshot Checklist:**
- ✅ Status code: 200 OK
- ✅ Response has `data` array
- ✅ All books are listed with complete information

---

#### Test 3: Get Specific Book

1. Create a new GET request
2. Set URL: `http://localhost:8000/api/v1/books/1` (use ID from previous test)
3. Set Headers:
   - `Accept`: `application/json`
4. Click **Send**
5. **Expected Result:** 200 OK with single book data

---

#### Test 4: Update a Book

1. Create a new PUT request
2. Set URL: `http://localhost:8000/api/v1/books/1`
3. Set Headers:
   - `Content-Type`: `application/json`
   - `Accept`: `application/json`
4. Set Body (raw JSON):
   ```json
   {
     "title": "Laravel 12: Complete Guide - Updated",
     "available": false
   }
   ```
5. Click **Send**
6. **Expected Result:** 200 OK with updated book data

**Screenshot Checklist:**
- ✅ Status code: 200 OK
- ✅ Title is updated
- ✅ Available status changed to false
- ✅ `updated_at` timestamp is newer

---

#### Test 5: Delete a Book

1. Create a new DELETE request
2. Set URL: `http://localhost:8000/api/v1/books/1`
3. Set Headers:
   - `Accept`: `application/json`
4. Click **Send**
5. **Expected Result:** 200 OK with success message

**Screenshot Checklist:**
- ✅ Status code: 200 OK
- ✅ Message: "Book deleted successfully"
- ✅ Verify deletion by trying GET request (should return 404)

---

#### Test 6: Validation Testing

**Test Invalid Data:**

1. Create POST request to `http://localhost:8000/api/v1/books`
2. Send empty body or invalid data:
   ```json
   {
     "title": "",
     "author": "Test",
     "isbn": "invalid"
   }
   ```
3. **Expected Result:** 422 Unprocessable Entity

**Screenshot Checklist:**
- ✅ Status code: 422 Unprocessable Entity
- ✅ Response contains `errors` object
- ✅ Custom validation messages are shown
- ✅ All required fields are validated

---

#### Test 7-11: Repeat for Members API

Follow the same pattern for Members API endpoints with appropriate data:

**Sample Member Data:**
```json
{
  "student_id": "STU99999",
  "name": "John Doe",
  "email": "john.doe@example.com",
  "phone": "+1234567890",
  "member_since": "2025-01-01"
}
```

---

### Advanced Postman Features

#### 1. Environment Variables

Create environment variables for easy switching:
- `base_url`: `http://localhost:8000/api/v1`
- Usage: `{{base_url}}/books`

#### 2. Tests Scripts

Add automatic validation in Postman Tests tab:

```javascript
// Test for successful creation
pm.test("Status code is 201", function () {
    pm.response.to.have.status(201);
});

pm.test("Response has data object", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData).to.have.property('data');
});

pm.test("Book has required fields", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData.data).to.have.property('id');
    pm.expect(jsonData.data).to.have.property('title');
    pm.expect(jsonData.data).to.have.property('author');
});
```

#### 3. Pre-request Scripts

Save IDs automatically for subsequent requests:

```javascript
// Save book ID from response
pm.test("Save book ID", function () {
    var jsonData = pm.response.json();
    pm.environment.set("book_id", jsonData.data.id);
});

// Use in next request URL: {{base_url}}/books/{{book_id}}
```

---

### Complete Test Scenarios

#### Scenario 1: Complete Book Lifecycle
1. ✅ Create a new book (201 Created)
2. ✅ Get all books - verify new book exists (200 OK)
3. ✅ Get specific book by ID (200 OK)
4. ✅ Update book information (200 OK)
5. ✅ Delete book (200 OK)
6. ✅ Try to get deleted book (404 Not Found)

#### Scenario 2: Validation Testing
1. ✅ Create book without title (422 - validation error)
2. ✅ Create book with duplicate ISBN (422 - unique constraint)
3. ✅ Create book with future year (422 - max year validation)
4. ✅ Create member with invalid email (422 - email format)
5. ✅ Create member with duplicate email (422 - unique constraint)

#### Scenario 3: Error Handling
1. ✅ Get non-existent book (404 Not Found)
2. ✅ Update non-existent member (404 Not Found)
3. ✅ Delete non-existent resource (404 Not Found)

---

## Running Automated Tests

The API includes comprehensive Pest test suite. Run tests with:

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test --filter=BookApiTest
php artisan test --filter=MemberApiTest

# Run with coverage
php artisan test --coverage
```

**Test Coverage:**
- ✅ All CRUD operations for Books and Members
- ✅ Validation rules and error messages
- ✅ HTTP status codes
- ✅ JSON structure validation
- ✅ Database integrity checks
- ✅ Edge cases and error scenarios

---

## Notes

- All responses are in JSON format
- Timestamps are in ISO 8601 format
- The API uses Laravel's implicit route model binding for `{book}` and `{member}` parameters
- Validation errors return detailed messages in both English and custom messages
- The API follows RESTful conventions for HTTP methods and status codes

---

## Support

For issues or questions:
1. Check the test files: `tests/Feature/Api/V1/`
2. Review validation rules in: `app/Http/Requests/`
3. Verify routes: `php artisan route:list`

---

**Last Updated:** November 18, 2025  
**Laravel Version:** 12.38.1  
**API Version:** v1
