<?php

use App\Services\ImageService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/admin.php';

Route::get('/image/{size}/{image}', function ($size, $image) {
    return (new ImageService)->getImage($image, $size);
});
