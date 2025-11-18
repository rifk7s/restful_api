# RESTful API Perpustakaan - Postman Testing Guide

## Table of Contents
1. [Overview](#overview)
2. [Base URL](#base-url)
3. [Screenshot Requirements](#screenshot-requirements)
4. [API Endpoints](#api-endpoints)
   - [Books API](#books-api)
   - [Members API](#members-api)

---

## Overview

RESTful API untuk Sistem Informasi Perpustakaan Universitas.
Dokumen ini berisi panduan untuk mengambil screenshot Postman sesuai requirements PDF.

---

## Base URL

```
http://localhost:8000/api
```

**Important:** Setiap request di Postman harus menyertakan header:
- `Accept: application/json`
- `Content-Type: application/json` (untuk POST/PATCH)

---

## Screenshot Requirements

Berdasarkan PDF Section 4.2, screenshot Postman diperlukan untuk:

### Buku (Books)
1. ✅ POST /api/books - Create book (201 Created)
2. ✅ GET /api/books - List all books (200 OK)
3. ✅ GET /api/books/1 - Get specific book (200 OK / 404 Not Found)
4. ✅ PATCH /api/books/1 - Update stock (200 OK / 404 Not Found)
5. ✅ DELETE /api/books/1 - Delete book (204 No Content)

### Anggota (Members)
6. ✅ POST /api/members - Create member (201 Created)
7. ✅ POST /api/members - Duplicate student_id (422 Unprocessable)
8. ✅ GET /api/members/1 - Get specific member (200 OK / 404 Not Found)
9. ✅ DELETE /api/members/1 - Delete member (204 No Content)

**Additional Requirements:**
- GET /api/books/ID untuk ID yang sudah dihapus → 404 Not Found
- POST /api/members dengan email duplikat → 422 Unprocessable

---

## API Endpoints

### Books API

#### 1. POST - Create Book 

**Endpoint:** `POST /api/books`

**Request Body:**
```json
{
  "isbn": "978-0123456789",
  "title": "Laravel Mastery",
  "author": "John Doe",
  "published_year": 2023,
  "stock": 10
}
```

**Expected Response:** `201 Created`
```json
{
  "data": {
    "id": 1,
    "title": "Laravel Mastery",
    "author": "John Doe",
    "isbn": "978-0123456789",
    "published_year": 2023,
    "stock": 10,
    "created_at": "2025-11-18T02:34:39.000000Z",
    "updated_at": "2025-11-18T02:34:39.000000Z"
  }
}
```

---

#### 2. GET - List All Books 

**Endpoint:** `GET /api/books`

**Expected Response:** `200 OK`
```json
{
  "data": [
    {
      "id": 1,
      "title": "Laravel Mastery",
      "author": "John Doe",
      "isbn": "978-0123456789",
      "published_year": 2023,
      "stock": 10,
      "created_at": "2025-11-18T02:34:39.000000Z",
      "updated_at": "2025-11-18T02:34:39.000000Z"
    }
  ]
}
```

---

#### 3. GET - Get Specific Book 

**Endpoint:** `GET /api/books/1`

**Expected Response:** `200 OK`
```json
{
  "data": {
    "id": 1,
    "title": "Laravel Mastery",
    "author": "John Doe",
    "isbn": "978-0123456789",
    "published_year": 2023,
    "stock": 10,
    "created_at": "2025-11-18T02:34:39.000000Z",
    "updated_at": "2025-11-18T02:34:39.000000Z"
  }
}
```

**Or if not found:** `404 Not Found`
```json
{
  "message": "No query results for model [App\\Models\\Book] 999"
}
```

---

#### 4. PATCH - Update Book Stock 

**Endpoint:** `PATCH /api/books/1`

**Request Body:**
```json
{
  "stock": 12
}
```

**Expected Response:** `200 OK`
```json
{
  "data": {
    "id": 1,
    "title": "Laravel Mastery",
    "author": "John Doe",
    "isbn": "978-0123456789",
    "published_year": 2023,
    "stock": 12,
    "created_at": "2025-11-18T02:34:39.000000Z",
    "updated_at": "2025-11-18T02:40:00.000000Z"
  }
}
```

**Or if not found:** `404 Not Found`

---

#### 5. DELETE - Delete Book 

**Endpoint:** `DELETE /api/books/1`

**Expected Response:** `204 No Content`
```
(Empty response body)
```

**Or if not found:** `404 Not Found`

---

#### 6. GET - Deleted Book (404) 

**Endpoint:** `GET /api/books/1` (setelah dihapus)

**Expected Response:** `404 Not Found`
```json
{
  "message": "No query results for model [App\\Models\\Book] 1"
}
```

---

### Members API

#### 1. POST - Create Member 

**Endpoint:** `POST /api/members`

**Request Body:**
```json
{
  "student_id": "STU12345",
  "name": "Alice Johnson",
  "email": "alice@example.com"
}
```

**Expected Response:** `201 Created`
```json
{
  "data": {
    "id": 1,
    "student_id": "STU12345",
    "name": "Alice Johnson",
    "email": "alice@example.com",
    "created_at": "2025-11-18T02:34:39.000000Z",
    "updated_at": "2025-11-18T02:34:39.000000Z"
  }
}
```

---

#### 2. POST - Duplicate Student ID (422) 

**Endpoint:** `POST /api/members`

**Request Body:** (gunakan student_id yang sama)
```json
{
  "student_id": "STU12345",
  "name": "Bob Smith",
  "email": "bob@example.com"
}
```

**Expected Response:** `422 Unprocessable Entity`
```json
{
  "message": "This student ID is already registered",
  "errors": {
    "student_id": [
      "This student ID is already registered"
    ]
  }
}
```

---

#### 3. POST - Duplicate Email (422)

**Endpoint:** `POST /api/members`

**Request Body:** (gunakan email yang sama)
```json
{
  "student_id": "STU99999",
  "name": "Charlie Brown",
  "email": "alice@example.com"
}
```

**Expected Response:** `422 Unprocessable Entity`
```json
{
  "message": "This email is already registered",
  "errors": {
    "email": [
      "This email is already registered"
    ]
  }
}
```

---

#### 4. GET - Get Specific Member 

**Endpoint:** `GET /api/members/1`

**Expected Response:** `200 OK`
```json
{
  "data": {
    "id": 1,
    "student_id": "STU12345",
    "name": "Alice Johnson",
    "email": "alice@example.com",
    "created_at": "2025-11-18T02:34:39.000000Z",
    "updated_at": "2025-11-18T02:34:39.000000Z"
  }
}
```

**Or if not found:** `404 Not Found`

---

#### 5. DELETE - Delete Member 
**Endpoint:** `DELETE /api/members/1`

**Expected Response:** `204 No Content`
```
(Empty response body)
```

---

## Postman Testing Guide

### Setup

1. Start server:
   ```bash
   php artisan serve
   ```

2. Open Postman

3. **IMPORTANT:** Set Headers untuk setiap request:
   - `Accept: application/json`
   - `Content-Type: application/json` (untuk POST/PATCH)

---

### Testing Order (Recommended)

#### BOOKS (Tests 1-6)

1. **POST /api/books** - Create book (201) ✅
2. **GET /api/books** - List all books (200) ✅
3. **GET /api/books/1** - Get specific book (200) ✅
4. **PATCH /api/books/1** - Update stock (200) ✅
5. **DELETE /api/books/1** - Delete book (204) ✅
6. **GET /api/books/1** - Get deleted book (404) ✅

#### MEMBERS (Tests 7-9)

7. **POST /api/members** - Create member (201) ✅
8. **POST /api/members** - Duplicate student_id (422) ✅
9. **POST /api/members** - Duplicate email (422) ✅
10. **GET /api/members/1** - Get specific member (200) ✅
11. **DELETE /api/members/1** - Delete member (204) ✅

---

## Quick Reference

### Books Endpoints
```
POST   /api/books       - Create book
GET    /api/books       - List all books
GET    /api/books/1     - Get book by ID
PATCH  /api/books/1     - Update book stock
DELETE /api/books/1     - Delete book
```

### Members Endpoints
```
POST   /api/members     - Create member
GET    /api/members/1   - Get member by ID
DELETE /api/members/1   - Delete member
```

### Expected Status Codes
```
201 - Created (POST success)
200 - OK (GET/PATCH success)
204 - No Content (DELETE success)
404 - Not Found (resource doesn't exist)
422 - Unprocessable Entity (validation failed)
```

---

**Last Updated:** November 18, 2025  
**PDF Compliance:** Section 4.2 - Panduan Pengujian Postman
