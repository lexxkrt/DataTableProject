<?php

use App\Pages\Admin\BrandPage;
use App\Pages\Admin\CategoryPage;
use App\Pages\Admin\ProductPage;
use App\Pages\Admin\UserPage;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('users', UserPage::class)->name('users');
    Route::get('brands', BrandPage::class)->name('brands');
    Route::get('categories', CategoryPage::class)->name('categories');
    Route::get('products', ProductPage::class)->name('products');
});
