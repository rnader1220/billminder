<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EntryController;

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
        Route::get('/{entry_id}/cycle', [EntryController::class, 'getCycle']);
        Route::post('/{entry_id}/cycle', [EntryController::class, 'postCycle']);
    });


});
