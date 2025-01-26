<?php

use App\Http\Controllers\Shortener\ShortenerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{id}', [ShortenerController::class, 'redirect']);

