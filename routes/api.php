<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('cors')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('find', 'Site\ApiController@findOrCreateUser');
        Route::get('get/{email}', 'Site\ApiController@getUser');
        Route::get('update/{id}', 'Site\ApiController@updateUser');
        Route::get('delete/{id}', 'Site\ApiController@deleteUser');
        Route::post('uploadimage/{id}', 'Site\ApiController@uploadImageUser');
        Route::get('avatar/{id}', 'Site\ApiController@getImageUser');
    });

    Route::prefix('menutype')->group(function () {
        Route::get('all/{preferredShop_id}', 'Site\ApiController@listMenuType');
    });

    Route::prefix('menuitem')->group(function () {
        Route::get('all/{menutype_id}/{preferredShop_id}', 'Site\ApiController@listMenuItem');
        Route::get('image/{id}', 'Site\ApiController@getMenuItemImage');
    });

    Route::prefix('menuextra')->group(function () {
        Route::get('all/{menuitem_id}', 'Site\ApiController@listMenuExtra');
    });

    Route::prefix('orderhistory')->group(function () {
        Route::get('all/{user_id}', 'Site\ApiController@listOrderHistory');
        Route::get('find/{id}', 'Site\ApiController@findOrderHistory');
        Route::get('orderagain/{id}/{user_id}', 'Site\ApiController@orderAgain');
    });

    Route::prefix('checkout')->group(function () {
        Route::get('get/{user_id}', 'Site\ApiController@getShoppingCart');
        Route::get('additem/{user_id}', 'Site\ApiController@addItemToShoppingCart');
        Route::get('removeitem/{user_id}/{checkoutitem_id}', 'Site\ApiController@removeItemFromShoppingCart');
        Route::get('plusitem/{user_id}/{checkoutitem_id}', 'Site\ApiController@plusItemToShoppingCart');
        Route::get('minusitem/{user_id}/{checkoutitem_id}', 'Site\ApiController@minusItemFromShoppingCart');
        Route::get('plusridertip/{user_id}', 'Site\ApiController@plusRiderTip');
        Route::get('minusridertip/{user_id}', 'Site\ApiController@minusRiderTip');
        Route::get('confirm/{user_id}/{shop_id}', 'Site\ApiController@confirmCheckout');
    });

    Route::prefix('shop')->group(function () {
        Route::get('all/{openedShops}', 'Site\ApiController@listShops');
    });

    Route::prefix('contactus')->group(function () {
        Route::get('send', 'Site\ApiController@sendMail');
    });
});
