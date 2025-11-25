<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Include Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    require __DIR__.'/webs/web-admin.php';
});

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

