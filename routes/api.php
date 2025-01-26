<?php

use App\Http\Controllers\Shortener\ShortenerController;
use Illuminate\Support\Facades\Route;

Route::controller(ShortenerController::class)->prefix('url')->group(function(){
    Route::get('/', [ShortenerController::class, 'index']);
    Route::post('/',  [ShortenerController::class, 'store']);
    Route::delete('/{id}',  [ShortenerController::class, 'destroy']);
});
