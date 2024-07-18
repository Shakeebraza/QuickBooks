<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuickBooksController;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/signup', [LoginController::class, 'showSignupForm'])->name('signup');

Route::get('/connect', [QuickBooksController::class, 'connect'])->name('quickbooks.connect');
Route::get('/callback', [QuickBooksController::class, 'callback'])->name('quickbooks.callback');