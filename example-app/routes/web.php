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
Route::get('/faq', function () {
    return view('faq');
});
Route::get('/how-it-works-lands', function () {
    return view('how-it-works-lands');
});
Route::get('/how-it-works-houses', function () {
    return view('how-it-works-houses');
});


Route::get('/compreport', function () {
    return view('compreport');
});

Route::get('/compreport2', function () {
    return view('compreport2');
});
Route::get('/priceland', function () {
    return view('priceland');
});
Route::get('/pricehouse', function () {
    return view('pricehouse');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/support', function () {
    return view('support');
});

Route::get('/verify-mail/{token}',[ApiController::class,'verifyEmailToken']);



//Route::post('/register', [ ApiController::class,'register']);
//Route::post('/login', [ ApiController::class,'login']);
