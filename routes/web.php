<?php

use App\Http\Controllers\Shortener\ShortenerController;
use Illuminate\Support\Facades\Route;

Route::get('/u/{id}', [ShortenerController::class, 'redirect']);

Route::view('/{path?}', 'welcome')->where('path', '^(?!api).*$');;
