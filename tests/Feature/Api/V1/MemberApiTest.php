<?php

use App\Models\Member;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

beforeEach(function () {
    $this->artisan('migrate:fresh');
});

it('can list all members', function () {
    Member::factory()->count(3)->create();

    getJson('/api/members')
        ->assertSuccessful()
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'student_id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
});

it('can create a new member', function () {
    $memberData = [
        'student_id' => 'STU12345',
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ];

    postJson('/api/members', $memberData)
        ->assertCreated()
        ->assertJsonFragment([
            'student_id' => 'STU12345',
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

    $this->assertDatabaseHas('members', [
        'student_id' => 'STU12345',
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
});

it('requires student_id when creating a member', function () {
    $memberData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ];

    postJson('/api/members', $memberData)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['student_id']);
});

it('requires name when creating a member', function () {
    $memberData = [
        'student_id' => 'STU12345',
        'email' => 'john@example.com',
    ];

    postJson('/api/members', $memberData)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['name']);
});

it('requires unique student_id when creating a member', function () {
    $existingMember = Member::factory()->create(['student_id' => 'STU12345']);

    $memberData = [
        'student_id' => 'STU12345',
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ];

    postJson('/api/members', $memberData)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['student_id']);
});

it('requires unique email when creating a member', function () {
    $existingMember = Member::factory()->create(['email' => 'john@example.com']);

    $memberData = [
        'student_id' => 'STU12345',
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ];

    postJson('/api/members', $memberData)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});

it('requires valid email format', function () {
    $memberData = [
        'student_id' => 'STU12345',
        'name' => 'John Doe',
        'email' => 'invalid-email',
    ];

    postJson('/api/members', $memberData)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});

it('can show a specific member', function () {
    $member = Member::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    getJson("/api/members/{$member->id}")
        ->assertSuccessful()
        ->assertJsonFragment([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
});

it('returns 404 when member not found', function () {
    getJson('/api/members/999')
        ->assertNotFound();
});

it('can update a member', function () {
    $member = Member::factory()->create([
        'name' => 'Old Name',
    ]);

    $updateData = [
        'name' => 'New Name',
    ];

    putJson("/api/members/{$member->id}", $updateData)
        ->assertSuccessful()
        ->assertJsonFragment([
            'name' => 'New Name',
        ]);

    $this->assertDatabaseHas('members', [
        'id' => $member->id,
        'name' => 'New Name',
    ]);
});

it('can delete a member', function () {
    $member = Member::factory()->create();

    deleteJson("/api/members/{$member->id}")
        ->assertNoContent();

    $this->assertDatabaseMissing('members', [
        'id' => $member->id,
    ]);
});
