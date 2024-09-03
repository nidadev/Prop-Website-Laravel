<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\PDFController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//open routes



//auth routes
Route::group([
    "middleware" => "api"
], function () {
    Route::post('register', [ApiController::class, 'register']);
    Route::post('login', [ApiController::class, 'login']);
    Route::get("profile", [ApiController::class, "profile"]);
    Route::get("refreshToken", [ApiController::class, "refreshToken"]);
    Route::post("logout", [ApiController::class, "logout"]);
    Route::post('profile-update', [ApiController::class, "updateProfile"]);
    Route::get('send-verify-mail/{email}',[ApiController::class,"verifyEmail"]);
    Route::post('research', [ApiController::class, 'research']);
    //Route::post('pdf2', [PDFController::class, 'index']);
    Route::post('pdf', [ApiController::class, 'pdf_download']);

    

});
