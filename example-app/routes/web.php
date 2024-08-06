<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\IsCorsMiddleware;
use App\Http\Controllers\Api\ApiController;

Route::get('/home', function () {
    return view('welcome');
})->middleware(IsCorsMiddleware::class);

Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/profile', function () {
    return view('profile');
});

/*Route::get('/me', function () {
    return view('layouts.nav');
})*/

Route::get('/subscription', function () {
    return view('subscription');
});

/*Route::get('/logout', function () {
    return view('logout');
});*/

Route::get('/research', function () {
    return view('research');
});

Route::get('/compreport', function () {
    return view('compreport');
});



Route::post('/register', [ ApiController::class,'register']);
Route::post('/login', [ ApiController::class,'login']);
