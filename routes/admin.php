<?php

use App\Pages\Admin\BrandPage;
use App\Pages\Admin\CategoryPage;
use App\Pages\Admin\HomePage;
use App\Pages\Admin\ModelChangeLogPage;
use App\Pages\Admin\ProductPage;
use App\Pages\Admin\UserPage;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', HomePage::class)->name('home');
    Route::get('users', UserPage::class)->name('users');
    Route::get('brands', BrandPage::class)->name('brands');
    Route::get('categories', CategoryPage::class)->name('categories');
    Route::get('products', ProductPage::class)->name('products');
    Route::get('logs', ModelChangeLogPage::class)->name('logs');
    Route::get('users', UserPage::class)->name('users');
});
