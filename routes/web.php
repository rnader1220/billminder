<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AccountController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::prefix('entry')->group(function () {
        Route::get('/list', [EntryController::class, 'index'])->name('entries');
        Route::get('/create', [EntryController::class, 'create']);
        Route::post('/store', [EntryController::class, 'store']);
        Route::get('/{entry_id}', [EntryController::class, 'show']);
        Route::get('/{entry_id}/edit', [EntryController::class, 'edit']);
        Route::patch('/{entry_id}', [EntryController::class, 'update']);
        Route::delete('/{entry_id}', [EntryController::class, 'destroy']);
        Route::get('/{entry_id}/cycle', [EntryController::class, 'createCycle']);
        Route::post('/{entry_id}/cycle', [EntryController::class, 'postCycle']);
    });
    Route::prefix('category')->group(function () {
        Route::get('/list', [CategoryController::class, 'index'])->name('entries');
        Route::get('/create', [CategoryController::class, 'create']);
        Route::post('/store', [CategoryController::class, 'store']);
        Route::get('/{entry_id}', [CategoryController::class, 'show']);
        Route::get('/{entry_id}/edit', [CategoryController::class, 'edit']);
        Route::patch('/{entry_id}', [CategoryController::class, 'update']);
        Route::delete('/{entry_id}', [CategoryController::class, 'destroy']);

    });

    Route::prefix('account')->group(function () {
        Route::get('/list', [AccountController::class, 'index'])->name('entries');
        Route::get('/create', [AccountController::class, 'create']);
        Route::post('/store', [AccountController::class, 'store']);
        Route::get('/{entry_id}', [AccountController::class, 'show']);
        Route::get('/{entry_id}/edit', [AccountController::class, 'edit']);
        Route::patch('/{entry_id}', [AccountController::class, 'update']);
        Route::delete('/{entry_id}', [AccountController::class, 'destroy']);

    });
 

});
