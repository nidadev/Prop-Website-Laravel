<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\IsCorsMiddleware;
use App\Http\Controllers\Api\ApiController;

Route::get('/', function () {
    return view('welcome');
})->middleware(IsCorsMiddleware::class);

Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/register', [ ApiController::class,'register']);
Route::post('/login', [ ApiController::class,'login']);
