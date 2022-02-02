<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\Controller as AdminController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DeliveryController as AdminDeliveryController;
use App\Http\Controllers\Admin\DeliveryAddressController as AdminDeliveryAddressController;

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\shop\InformationController;
use App\Http\Controllers\Api\shop\MenuController;
use App\Http\Controllers\Api\shop\ProductController;
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
    Route::post('/login',[AdminController::class,'admin_login']);
    Route::get('/dashboard',[AdminController::class,'dashboard']);
    Route::resource('users',AdminUserController::class);
    Route::resource('deliveries',AdminDeliveryController::class);
    Route::get('deliveries/{id}/address',[AdminDeliveryAddressController::class,'index']);
    Route::put('deliveries/{id}/address',[AdminDeliveryAddressController::class,'update']);
    Route::get('/categories',[AdminCategoryController::class,'categories']);
});

Route::prefix('v1')->group(function (){
    Route::middleware('auth:sanctum')->group(function (){
        Route::prefix('user')->group(function (){
            Route::resource('/address',AddressController::class);
            Route::get('/me',[UserController::class,'me']);
            Route::patch('/me',[UserController::class,'update_user_information']);
        });
        Route::get('/providers/{category_id}/{sub_category_id}',[ProviderController::class,'index']);
        Route::get('/providers/{provider_slug}',[ProviderController::class,'provider']);
        Route::post('/providers/{id}/like',[ProviderController::class,'provider_like_or_dislike']);
        Route::get('/search',[UserController::class,'get_search']);
        Route::get('/my-orders',[UserController::class,'my_orders']);
        Route::get('/my-order-tracking',[UserController::class,'my_orders_tracking']);
        Route::prefix('my-shop')->group(function (){
            Route::get('/menus',[MenuController::class,'menus']);
            Route::delete('/menus/{id}',[MenuController::class,'menus_destroy']);
            Route::get('/menus/{id}',[MenuController::class,'get_menu']);
            Route::post('/menus',[MenuController::class,'create_menus']);
            Route::put('/menus/{id}',[MenuController::class,'edit_menus']);

            Route::get('/menus/{id}/products',[ProductController::class,'products']);
            Route::get('/menus/{menu_id}/products/{product_id}',[ProductController::class,'get_product']);
            Route::put('/menus/{menu_id}/products/{product_id}',[ProductController::class,'edit_products']);
            Route::post('/menus/{menu_id}/products',[ProductController::class,'create_products']);
            Route::delete('/menus/{menu_id}/products/{product_id}',[ProductController::class,'products_destroy']);

            Route::get('/information',[InformationController::class,'information']);
            Route::put('/information/edit',[InformationController::class,'information_edit']);
        });
    });
    Route::get('/categories',[CategoryController::class,'categories']);
    Route::get('/cities',[CityController::class,'cities']);
    Route::prefix('auth')->group(function (){
        Route::post('/phone',[UserController::class,'check_phone_number']);//create or update user and send login code
        Route::post('/code',[UserController::class,'check_login_code']);
        Route::post('/providers/create',[UserController::class,'create_provider'])->middleware('auth:sanctum');
    });
});
