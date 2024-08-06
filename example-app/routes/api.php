<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//open routes
Route::post('register',[ApiController::class,'register']);
Route::post('login',[ApiController::class,'login']);


//auth routes
Route::group([
    "middleware" => ["auth:api"]
], function(){    
    Route::get("profile", [ApiController::class, "profile"]);
    Route::get("refreshToken", [ApiController::class, "refreshToken"]);
    Route::post("logout", [ApiController::class, "logout"]);
    Route::post('profile-update',[ApiController::class, "updateProfile"]);
});
