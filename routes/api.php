<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ProviderController;
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
    Route::resource('addresses',AddressController::class);
    Route::get('/providers/{category_id}/{sub_category_id}',[ProviderController::class,'index']);
});
