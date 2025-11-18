<?php

use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Library API',
        'version' => 'v1',
        'endpoints' => [
            'books' => '/api/v1/books',
            'members' => '/api/v1/members',
        ],
        'documentation' => 'See API_DOCUMENTATION.md for complete API documentation',
    ]);
});

Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        return response()->json([
            'message' => 'Library API v1',
            'endpoints' => [
                'books' => [
                    'list' => 'GET /api/v1/books',
                    'create' => 'POST /api/v1/books',
                    'show' => 'GET /api/v1/books/{id}',
                    'update' => 'PUT /api/v1/books/{id}',
                    'delete' => 'DELETE /api/v1/books/{id}',
                ],
                'members' => [
                    'list' => 'GET /api/v1/members',
                    'create' => 'POST /api/v1/members',
                    'show' => 'GET /api/v1/members/{id}',
                    'update' => 'PUT /api/v1/members/{id}',
                    'delete' => 'DELETE /api/v1/members/{id}',
                ],
            ],
            'documentation' => 'See API_DOCUMENTATION.md for complete API documentation',
        ]);
    });

    Route::apiResource('books', BookController::class);
    Route::apiResource('members', MemberController::class);
});
