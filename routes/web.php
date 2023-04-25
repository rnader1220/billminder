<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
});



Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::namespace('App\Http\Controllers')->group(function () {


        Route::any('/entry/{entry}/action', 'EntryController@action');
        Route::get('/entry/list', 'EntryController@index');
        Route::get('/account/list', 'AccountController@index');
        Route::get('/category/list', 'CategoryController@index');

        Route::get('/profile/subscriber', 'ProfileController@subscriber');
        Route::get('/profile/list', 'ProfileController@index');


        Route::resource('/entry', 'EntryController');
        Route::resource('/account', 'AccountController');
        Route::resource('/category', 'CategoryController');
        Route::resource('/profile', 'ProfileController');
    });
});
