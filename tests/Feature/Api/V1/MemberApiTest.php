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

    getJson('/api/v1/members')
        ->assertSuccessful()
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'member_since',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
});

it('can create a new member', function () {
    $memberData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+1234567890',
        'member_since' => '2023-01-01',
    ];

    postJson('/api/v1/members', $memberData)
        ->assertCreated()
        ->assertJsonFragment([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

    $this->assertDatabaseHas('members', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
});

it('requires name when creating a member', function () {
    $memberData = [
        'email' => 'john@example.com',
        'phone' => '+1234567890',
        'member_since' => '2023-01-01',
    ];

    postJson('/api/v1/members', $memberData)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['name']);
});

it('requires unique email when creating a member', function () {
    $existingMember = Member::factory()->create(['email' => 'john@example.com']);

    $memberData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+1234567890',
        'member_since' => '2023-01-01',
    ];

    postJson('/api/v1/members', $memberData)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});

it('requires valid email format', function () {
    $memberData = [
        'name' => 'John Doe',
        'email' => 'invalid-email',
        'phone' => '+1234567890',
        'member_since' => '2023-01-01',
    ];

    postJson('/api/v1/members', $memberData)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});

it('can show a specific member', function () {
    $member = Member::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    getJson("/api/v1/members/{$member->id}")
        ->assertSuccessful()
        ->assertJsonFragment([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
});

it('returns 404 when member not found', function () {
    getJson('/api/v1/members/999')
        ->assertNotFound();
});

it('can update a member', function () {
    $member = Member::factory()->create([
        'name' => 'Old Name',
    ]);

    $updateData = [
        'name' => 'New Name',
    ];

    putJson("/api/v1/members/{$member->id}", $updateData)
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

    deleteJson("/api/v1/members/{$member->id}")
        ->assertSuccessful()
        ->assertJson([
            'message' => 'Member deleted successfully',
        ]);

    $this->assertDatabaseMissing('members', [
        'id' => $member->id,
    ]);
});
