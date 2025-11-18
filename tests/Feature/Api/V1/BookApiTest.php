<?php

use App\Models\Book;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

beforeEach(function () {
    $this->artisan('migrate:fresh');
});

it('can list all books', function () {
    Book::factory()->count(3)->create();

    getJson('/api/v1/books')
        ->assertSuccessful()
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'author',
                    'isbn',
                    'published_year',
                    'available',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
});

it('can create a new book', function () {
    $bookData = [
        'title' => 'Test Book',
        'author' => 'John Doe',
        'isbn' => '978-0123456789',
        'published_year' => 2023,
        'available' => true,
    ];

    postJson('/api/v1/books', $bookData)
        ->assertCreated()
        ->assertJsonFragment([
            'title' => 'Test Book',
            'author' => 'John Doe',
        ]);

    $this->assertDatabaseHas('books', [
        'title' => 'Test Book',
        'isbn' => '978-0123456789',
    ]);
});

it('requires title when creating a book', function () {
    $bookData = [
        'author' => 'John Doe',
        'isbn' => '978-0123456789',
        'published_year' => 2023,
    ];

    postJson('/api/v1/books', $bookData)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['title']);
});

it('requires unique isbn when creating a book', function () {
    $existingBook = Book::factory()->create(['isbn' => '978-0123456789']);

    $bookData = [
        'title' => 'Test Book',
        'author' => 'John Doe',
        'isbn' => '978-0123456789',
        'published_year' => 2023,
    ];

    postJson('/api/v1/books', $bookData)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['isbn']);
});

it('can show a specific book', function () {
    $book = Book::factory()->create([
        'title' => 'Test Book',
        'author' => 'John Doe',
    ]);

    getJson("/api/v1/books/{$book->id}")
        ->assertSuccessful()
        ->assertJsonFragment([
            'title' => 'Test Book',
            'author' => 'John Doe',
        ]);
});

it('returns 404 when book not found', function () {
    getJson('/api/v1/books/999')
        ->assertNotFound();
});

it('can update a book', function () {
    $book = Book::factory()->create([
        'title' => 'Old Title',
    ]);

    $updateData = [
        'title' => 'New Title',
    ];

    putJson("/api/v1/books/{$book->id}", $updateData)
        ->assertSuccessful()
        ->assertJsonFragment([
            'title' => 'New Title',
        ]);

    $this->assertDatabaseHas('books', [
        'id' => $book->id,
        'title' => 'New Title',
    ]);
});

it('can delete a book', function () {
    $book = Book::factory()->create();

    deleteJson("/api/v1/books/{$book->id}")
        ->assertSuccessful()
        ->assertJson([
            'message' => 'Book deleted successfully',
        ]);

    $this->assertDatabaseMissing('books', [
        'id' => $book->id,
    ]);
});

it('validates published year is not in future', function () {
    $futureYear = date('Y') + 2;

    $bookData = [
        'title' => 'Test Book',
        'author' => 'John Doe',
        'isbn' => '978-0123456789',
        'published_year' => $futureYear,
    ];

    postJson('/api/v1/books', $bookData)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['published_year']);
});
