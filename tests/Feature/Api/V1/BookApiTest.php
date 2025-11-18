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

    getJson('/api/books')
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
                    'stock',
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
        'stock' => 10,
    ];

    postJson('/api/books', $bookData)
        ->assertCreated()
        ->assertJsonFragment([
            'title' => 'Test Book',
            'author' => 'John Doe',
            'stock' => 10,
        ]);

    $this->assertDatabaseHas('books', [
        'title' => 'Test Book',
        'isbn' => '978-0123456789',
        'stock' => 10,
    ]);
});

it('requires title when creating a book', function () {
    $bookData = [
        'author' => 'John Doe',
        'isbn' => '978-0123456789',
        'published_year' => 2023,
    ];

    postJson('/api/books', $bookData)
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

    postJson('/api/books', $bookData)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['isbn']);
});

it('can show a specific book', function () {
    $book = Book::factory()->create([
        'title' => 'Test Book',
        'author' => 'John Doe',
    ]);

    getJson("/api/books/{$book->id}")
        ->assertSuccessful()
        ->assertJsonFragment([
            'title' => 'Test Book',
            'author' => 'John Doe',
        ]);
});

it('returns 404 when book not found', function () {
    getJson('/api/books/999')
        ->assertNotFound();
});

it('can update a book', function () {
    $book = Book::factory()->create([
        'title' => 'Old Title',
    ]);

    $updateData = [
        'title' => 'New Title',
    ];

    putJson("/api/books/{$book->id}", $updateData)
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

    deleteJson("/api/books/{$book->id}")
        ->assertNoContent();

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

    postJson('/api/books', $bookData)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['published_year']);
});
