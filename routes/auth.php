<?php

use App\Pages\Auth\LoginPage;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', LoginPage::class)->name('login');
});

Route::match(['get', 'post'], 'logout', function () {
    auth('web')->logout();

    session()->invalidate();
    session()->regenerateToken();

    return redirect(route('login'));
})->name('logout');
