<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\TokenAuthController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//open routes



//auth routes
Route::group([
    "middleware" => "api"
], function () {
    Route::post('register', [ApiController::class, 'register'])->middleware('throttle:5,1');
    Route::post('login', [TokenAuthController::class, 'login'])->middleware('throttle:10,1');
});
Route::middleware(['auth:sanctum', 'IsAuth'])->group(function () {
    Route::post('land/price', [\App\Http\Controllers\PropertyApiController::class, 'price'])->middleware(['userAuth', 'abilities:property:read', 'throttle:5,1']);
    Route::post('land/comps', [\App\Http\Controllers\PropertyApiController::class, 'comps'])->middleware(['userAuth', 'abilities:property:read', 'throttle:5,1']);
    Route::get("profile", [ApiController::class, "profile"]);
    Route::post("refreshToken", [TokenAuthController::class, "refresh"]);
    Route::post("logout", [TokenAuthController::class, "logout"]);
    Route::post('profile-update', [ApiController::class, "updateProfile"]);
    //Route::post('pdf2', [PDFController::class, 'index']);

    

});
