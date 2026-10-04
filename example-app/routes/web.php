<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\IsCorsMiddleware;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\SubscriptionController;

Route::get('/', [ApiController::class, 'loadHome']);

Route::get('/faq', function () {
    return view('faq');
});
Route::get('/how-it-works-lands', function () {
    return view('how-it-works-lands');
});
Route::get('/how-it-works-houses', function () {
    return view('how-it-works-houses');
});
Route::get('/about', function () {
    return view('about');
});

Route::get('/subscription-home', function () {
    return view('subscription-home');
});

Route::group(['middleware' => ['guest']],function(){
    Route::get('/login', [ApiController::class, 'loadLogin']);
    Route::post('/login', [ApiController::class,'userLogin'])->middleware('throttle:10,1')->name('userLogin');
    Route::get('/register', [ApiController::class,'loadRegister'])->name('loadRegister');
    Route::post('/register', [ApiController::class,'register'])->middleware('throttle:5,1')->name('register');

});

Route::group(['middleware' => ['userAuth']],function(){
    Route::get('/land-comps', [\App\Http\Controllers\CompsController::class, 'index']);
    Route::post('/land-comps', [\App\Http\Controllers\CompsController::class, 'store'])->middleware('throttle:5,1');
    Route::get('/land-comps/{id}', [\App\Http\Controllers\CompsController::class, 'show'])->whereNumber('id');
    Route::get('/land-comps/{id}/download', [\App\Http\Controllers\CompsController::class, 'download'])->whereNumber('id');
    Route::get('/land-valuation', [\App\Http\Controllers\LandValuationController::class, 'index']);
    Route::post('/land-valuation', [\App\Http\Controllers\LandValuationController::class, 'store'])->middleware('throttle:5,1');
    Route::get('/land-valuation/{id}', [\App\Http\Controllers\LandValuationController::class, 'show'])->whereNumber('id');
    Route::get('/land-valuation/{id}/pdf', [\App\Http\Controllers\LandValuationController::class, 'pdf'])->whereNumber('id')->middleware('purchased:land_report');
    Route::get('/dashboard',[ApiController::class,'dashboard'])->name('dashboard');
    Route::get('/compreport', [ApiController::class,'loadCompReport'])->name('compreport')->middleware('datatree');
    


    Route::post('/compreport', [ApiController::class,'GetCompReport'])->name('compreport.submit')->middleware('datatree');

    Route::get('/priceland', [ApiController::class,'loadPriceReport'])->name('priceland')->middleware('datatree');
    //Route::post('/priceland', [ApiController::class,'GetPriceReport'])->name('priceland');
    Route::post('/priceland', [ApiController::class, 'GetPriceReport'])->middleware('datatree');
    Route::get('/get-report-results', [ApiController::class, 'getReportResults'])->name('get.report.results')->middleware('datatree');


    Route::get('/pricehouse', [ApiController::class,'loadPriceHouseReport'])->name('pricehouse')->middleware('datatree');
    
    Route::post('/pricehouse', [ApiController::class,'GetPriceHouseReport'])->middleware('datatree');
    Route::get('/get-house-results', [ApiController::class, 'getReportHouseResults'])->name('get.house.results')->middleware('datatree');

    Route::get('/research', [ApiController::class,'loadPriceResearchReport'])->name('research');
    Route::post('/research', [ApiController::class,'GetPriceResearchReport'])->name('research.submit')->middleware('datatree');
     

//
  
 
//checkout stripe
    Route::post('stripe',[\App\Http\Controllers\CheckoutController::class,'stripe'])->name('stripe');
    Route::get('success',[\App\Http\Controllers\CheckoutController::class,'success'])->name('success');
    Route::get('cancel',[\App\Http\Controllers\CheckoutController::class,'cancel'])->name('cancel');


    Route::get('/pdf/{id}', [ApiController::class, 'pdf_download2'])->middleware('purchased:comp_report')->middleware('datatree');
Route::get('/export/{id}', [ApiController::class, 'export_house_comp'])->middleware('purchased:owner_export')->middleware('datatree');
Route::get('/export_price/{pricehouseid}', [ApiController::class, 'export_house_comp'])->middleware('purchased:owner_export')->name('export_house')->middleware('datatree');

//Route::post('/webhook-subscription',SubscriptionController::class,'webhookSubscription')->name('webhookSubscription');

/************************************new export */

Route::post('/export-price-house', [ApiController::class, 'exportPriceHouse'])->middleware('purchased:owner_export')->name('exportprice')->middleware('datatree');

// Route to download the exported file
Route::get('/download-export/{fileName}', [ApiController::class, 'downloadExport'])->name('download.export');
/********************************* */
// Export cleanup is a maintenance operation, not a customer GET endpoint.
Route::get('/exports', [ApiController::class, 'showExports'])->name('exports');


Route::get('/download/xml/{id}', [ApiController::class, 'xmldownload'])->middleware('purchased:comp_report')->name('download.xml')->middleware('datatree');

});

Route::group(['middleware' => ['IsAuth']],function(){

    Route::get('/subscription',[\App\Http\Controllers\BillingController::class,'index'])->name('subscription');

    Route::post('/get-plan-details',[SubscriptionController::class,'getPlanDetails'])->name('getPlanDetails');

    Route::post('/logout', [ApiController::class,'Logout'])->name('logout');
    Route::post('/create-subscription', [\App\Http\Controllers\BillingController::class,'checkout'])->name('CreateSubscription')->middleware('payments');
    Route::post('/cancel-subscription', [\App\Http\Controllers\BillingController::class,'portal'])->name('CancelSubscription')->middleware('payments');
    
    Route::get('/getproperty', [ApiController::class,'loadProperty'])->name('getproperty')->middleware(['IsAdmin', 'datatree']);
    Route::post('/getproperty', [ApiController::class,'insert_prop_detail'])->name('getproperty.submit')->middleware(['IsAdmin', 'datatree']);
    
    Route::get('/getproperty2', [ApiController::class,'loadProperty2'])->name('getproperty2')->middleware(['IsAdmin', 'datatree']);
    Route::post('/getproperty2', [ApiController::class,'insert_prop_detail2'])->name('getproperty2.submit')->middleware(['IsAdmin', 'datatree']);
      

});


Route::get('/support', function () {
    return view('support');
});

Route::post('/support', [ApiController::class,'contactForm'])->middleware('throttle:5,1')->name('contactForm');
Route::post('/support/assistant', [\App\Http\Controllers\SupportAssistantController::class, 'reply'])->middleware('throttle:6,1');

Route::get('/forget', [ApiController::class,'forgetPasswordLoad'])->name('forget');
Route::post('/forget', [ApiController::class,'forgetPassword'])->middleware('throttle:5,1')->name('forgetPassword');

Route::get('/reset', [ApiController::class,'resetPasswordLoad'])->name('reset');
Route::post('/reset', [ApiController::class,'resetPassword'])->name('resetPassword');


Route::get('/terms', function () {
    return view('terms');
});
Route::get('/home', [ApiController::class, 'loadHome'])->name('home');


Route::get('/verify-mail/{token}', [ApiController::class, 'verifyEmailToken']);
Route::middleware('IsAdmin')->group(function () {
    Route::get('/adminpage', [\App\Http\Controllers\AdminController::class, 'index']);
    Route::post('/admin/users', [\App\Http\Controllers\AdminController::class, 'createUser']);
    Route::post('/admin/users/{user}', [\App\Http\Controllers\AdminController::class, 'updateUser']);
    Route::post('/admin/settings', [\App\Http\Controllers\AdminController::class, 'settings']);
    Route::post('/admin/pricing', [\App\Http\Controllers\AdminController::class, 'pricing']);
});
Route::view('/api-information', 'api-information');
Route::view('/bulk-data', 'bulk-data');
Route::view('/investor-marketplace', 'investor-marketplace');



Route::post('/stripe/webhook', [\App\Http\Controllers\CheckoutController::class, 'webhook']);

Route::middleware('IsAuth')->group(function () {
    Route::get('/credits', [\App\Http\Controllers\WalletController::class, 'index']);
    Route::post('/credits/topup', [\App\Http\Controllers\WalletController::class, 'topup'])->middleware(['userAuth', 'throttle:5,1'])->middleware('payments');
    Route::get('/saved-searches', [\App\Http\Controllers\SavedSearchController::class, 'index']);
    Route::post('/saved-searches', [\App\Http\Controllers\SavedSearchController::class, 'store'])->middleware('userAuth');
    Route::post('/saved-searches/{id}/run', [\App\Http\Controllers\SavedSearchController::class, 'run'])->middleware(['userAuth','datatree'])->whereNumber('id');
    Route::post('/saved-searches/{id}/remove', [\App\Http\Controllers\SavedSearchController::class, 'remove'])->whereNumber('id');
    Route::post('/saved-searches/{id}/restore', [\App\Http\Controllers\SavedSearchController::class, 'restore'])->whereNumber('id');
    Route::get('/list-upload', [\App\Http\Controllers\ListUploadController::class, 'index']);
    Route::post('/list-upload', [\App\Http\Controllers\ListUploadController::class, 'store'])->middleware('userAuth');
    Route::get('/list-upload/{id}', [\App\Http\Controllers\ListUploadController::class, 'show'])->whereNumber('id');
    Route::get('/list-upload/{id}/download', [\App\Http\Controllers\ListUploadController::class, 'download'])->whereNumber('id');
    Route::get('/profile', function () { return view('profile'); });
    Route::get('/profile-update', function () { return view('profile'); });
    Route::post('/profile-update', [ApiController::class, 'updateProfile'])->name('profile-update');
    Route::post('/send-verify-mail', function () { return app(ApiController::class)->verifyEmail(auth()->user()->email); })->middleware('throttle:3,1');
    Route::get('/billing/return', [\App\Http\Controllers\BillingController::class, 'returned'])->middleware('payments');
    Route::get('/billing/sync', [\App\Http\Controllers\BillingController::class, 'sync'])->middleware('payments');
    Route::post('/billing/portal', [\App\Http\Controllers\BillingController::class, 'portal'])->middleware('payments');
});
