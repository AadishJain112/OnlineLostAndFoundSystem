<?php

use App\Http\Controllers\Api\ApiCategoryController;
use App\Http\Controllers\Api\ApiFoundItemController;
use App\Http\Controllers\Api\ApiLostItemController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/categories', [ApiCategoryController::class, 'index']);
    Route::get('/lost-items', [ApiLostItemController::class, 'index']);
    Route::get('/lost-items/{lost_item:slug}', [ApiLostItemController::class, 'show']);
    Route::get('/found-items', [ApiFoundItemController::class, 'index']);
    Route::get('/found-items/{found_item:slug}', [ApiFoundItemController::class, 'show']);
});
