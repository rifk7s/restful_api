<?php

use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\MemberController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('books', BookController::class);
    Route::apiResource('members', MemberController::class);
});
