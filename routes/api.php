<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('admin')->group(function (){
    Route::get('/categories',[AdminCategoryController::class,'categories']);
});

Route::prefix('v1')->group(function (){
    Route::get('/categories',[CategoryController::class,'categories']);
    Route::get('/cities',[CityController::class,'cities']);
    Route::resource('/user/address',AddressController::class)->middleware('auth:sanctum');
    Route::get('/providers/{category_id}/{sub_category_id}',[ProviderController::class,'index']);
    Route::prefix('auth')->group(function (){
        Route::post('/phone',[UserController::class,'check_phone_number']);//create or update user and send login code
        Route::post('/code',[UserController::class,'check_login_code']);
    });
});
