<?php

Route::get('/', ['as'=>'site.home', 'uses'=>'Site\HomeController@index']);
Route::get('/contactus', ['as'=>'site.contactus', 'uses'=>'Site\HomeController@contactUs']);
Route::post('/contactus/send', ['as'=>'site.contactus.send', 'uses'=>'Site\HomeController@sendMessage']);

Route::get('/login', ['as'=>'site.login', 'uses'=>'Site\LoginController@index']);
Route::post('/login', ['as'=>'site.login', 'uses'=>'Site\LoginController@login']);
Route::get('/login/auth/{provider}', ['as'=>'site.login.social', 'uses'=>'Site\LoginController@redirectToProvider']);
Route::get('/login/auth/{provider}/return', ['as'=>'site.login.social.retorno', 'uses'=>'Site\LoginController@handleProviderCallback']);
Route::get('/login/forgotpassword', ['as'=>'site.login.forgot', 'uses'=>'Site\LoginController@forgotPassword']);
Route::post('/login/forgotpassword', ['as'=>'site.login.forgot', 'uses'=>'Site\LoginController@resetPassword']);
Route::get('/login/changepassword/{token}', ['as'=>'site.login.change', 'uses'=>'Site\LoginController@changePassword']);
Route::post('/login/changepassword/{user_id}', ['as'=>'site.login.save', 'uses'=>'Site\LoginController@savePassword']);
Route::get('/login/signup', ['as'=>'site.login.signup', 'uses'=>'Site\LoginController@signup']);
Route::post('/login/create', ['as'=>'site.login.create', 'uses'=>'Site\LoginController@createUser']);

Route::get('/site/checkout/shoppingcart', ['as'=>'site.checkout.shoppingcart', 'uses'=>'Site\CheckoutController@shoppingCart']);
Route::post('/site/checkout/additem', ['as'=>'site.checkout.additem', 'uses'=>'Site\CheckoutController@addItem']);
Route::get('/site/checkout/removeitem/{id}', ['as'=>'site.checkout.removeitem', 'uses'=>'Site\CheckoutController@removeItem']);
Route::get('/site/checkout/plusitem/{id}', ['as'=>'site.checkout.plusitem', 'uses'=>'Site\CheckoutController@plusItem']);
Route::get('/site/checkout/minusitem/{id}', ['as'=>'site.checkout.minusitem', 'uses'=>'Site\CheckoutController@minusItem']);
Route::get('/site/checkout/plustip', ['as'=>'site.checkout.plustip', 'uses'=>'Site\CheckoutController@plusTip']);
Route::get('/site/checkout/minustip', ['as'=>'site.checkout.minustip', 'uses'=>'Site\CheckoutController@minusTip']);
Route::post('/site/checkout/confirm', ['as'=>'site.checkout.confirm', 'uses'=>'Site\CheckoutController@confirm']);
Route::get('/site/checkout/address/{preferredShop}', ['as'=>'site.checkout.address', 'uses'=>'Site\CheckoutController@address']);
Route::put('/site/checkout/confirmAddress', ['as'=>'site.checkout.confirmAddress', 'uses'=>'Site\CheckoutController@confirmAddress']);


Route::group(['middleware'=>'auth'], function(){

	Route::get('/logout', ['as'=>'admin.logout', 'uses'=>'Site\LoginController@logout']);
	Route::get('/avatar/{id}', ['as'=>'admin.avatar', 'uses'=>'Site\HomeController@getAvatar']);

	Route::get('/admin/user', ['as'=>'admin.user', 'uses'=>'Admin\UserController@index']);
	Route::get('/admin/user/details/{id}', ['as'=>'admin.user.details', 'uses'=>'Admin\UserController@details']);
	Route::get('/admin/user/edit/{id}', ['as'=>'admin.user.edit', 'uses'=>'Admin\UserController@edit']);
	Route::put('/admin/user/update/{id}', ['as'=>'admin.user.update', 'uses'=>'Admin\UserController@update']);
	Route::get('/admin/user/delete/{id}', ['as'=>'admin.user.delete', 'uses'=>'Admin\UserController@delete']);
	Route::get('/admin/user/search', ['as'=>'admin.user.search', 'uses'=>'Admin\UserController@search']);
	Route::get('/admin/user/role/{user_id}', ['as'=>'admin.user.role', 'uses'=>'Admin\UserController@role']);
	Route::post('/admin/user/role/add/{user_id}', ['as'=>'admin.user.role.add', 'uses'=>'Admin\UserController@addRole']);
	Route::get('/admin/user/role/remove/{user_id}/{role_id}', ['as'=>'admin.user.role.remove', 'uses'=>'Admin\UserController@removeRole']);

	Route::get('/admin/role', ['as'=>'admin.role', 'uses'=>'Admin\RoleController@index']);
	Route::get('/admin/role/add', ['as'=>'admin.role.add', 'uses'=>'Admin\RoleController@add']);
	Route::post('/admin/role/save', ['as'=>'admin.role.save', 'uses'=>'Admin\RoleController@save']);
	Route::get('/admin/role/edit/{id}', ['as'=>'admin.role.edit', 'uses'=>'Admin\RoleController@edit']);
	Route::put('/admin/role/update/{id}', ['as'=>'admin.role.update', 'uses'=>'Admin\RoleController@update']);
	Route::get('/admin/role/delete/{id}', ['as'=>'admin.role.delete', 'uses'=>'Admin\RoleController@delete']);
	Route::get('/admin/role/permission/{role_id}', ['as'=>'admin.role.permission', 'uses'=>'Admin\RoleController@permission']);
	Route::post('/admin/role/permission/add/{role_id}', ['as'=>'admin.role.permission.add', 'uses'=>'Admin\RoleController@addPermission']);
	Route::get('/admin/role/permission/remove/{role_id}/{permission_id}', ['as'=>'admin.role.permission.remove', 'uses'=>'Admin\RoleController@removePermission']);

	Route::get('/admin/menutype', ['as'=>'admin.menutype', 'uses'=>'Admin\MenuTypeController@index']);
	Route::get('/admin/menutype/add', ['as'=>'admin.menutype.add', 'uses'=>'Admin\MenuTypeController@add']);
	Route::post('/admin/menutype/save', ['as'=>'admin.menutype.save', 'uses'=>'Admin\MenuTypeController@save']);
	Route::get('/admin/menutype/edit/{id}', ['as'=>'admin.menutype.edit', 'uses'=>'Admin\MenuTypeController@edit']);
	Route::put('/admin/menutype/update/{id}', ['as'=>'admin.menutype.update', 'uses'=>'Admin\MenuTypeController@update']);
	Route::get('/admin/menutype/delete/{id}', ['as'=>'admin.menutype.delete', 'uses'=>'Admin\MenuTypeController@delete']);
	
	Route::get('/admin/menutype/menuitem/{menutype_id}', ['as'=>'admin.menutype.menuitem', 'uses'=>'Admin\MenuItemController@index']);
	Route::get('/admin/menutype/menuitem/add/{menutype_id}', ['as'=>'admin.menutype.menuitem.add', 'uses'=>'Admin\MenuItemController@add']);
	Route::post('/admin/menutype/menuitem/save/{menutype_id}', ['as'=>'admin.menutype.menuitem.save', 'uses'=>'Admin\MenuItemController@save']);
	Route::get('/admin/menutype/menuitem/edit/{id}', ['as'=>'admin.menutype.menuitem.edit', 'uses'=>'Admin\MenuItemController@edit']);
	Route::put('/admin/menutype/menuitem/update/{id}', ['as'=>'admin.menutype.menuitem.update', 'uses'=>'Admin\MenuItemController@update']);
	Route::get('/admin/menutype/menuitem/delete/{id}', ['as'=>'admin.menutype.menuitem.delete', 'uses'=>'Admin\MenuItemController@delete']);

	Route::get('/admin/menutype/menuitem/menuextra/{menuitem_id}', ['as'=>'admin.menutype.menuitem.menuextra', 'uses'=>'Admin\MenuExtraController@index']);
	Route::get('/admin/menutype/menuitem/menuextra/add/{menuitem_id}', ['as'=>'admin.menutype.menuitem.menuextra.add', 'uses'=>'Admin\MenuExtraController@add']);
	Route::post('/admin/menutype/menuitem/menuextra/save/{menuitem_id}', ['as'=>'admin.menutype.menuitem.menuextra.save', 'uses'=>'Admin\MenuExtraController@save']);
	Route::get('/admin/menutype/menuitem/menuextra/edit/{id}', ['as'=>'admin.menutype.menuitem.menuextra.edit', 'uses'=>'Admin\MenuExtraController@edit']);
	Route::put('/admin/menutype/menuitem/menuextra/update/{id}', ['as'=>'admin.menutype.menuitem.menuextra.update', 'uses'=>'Admin\MenuExtraController@update']);
	Route::get('/admin/menutype/menuitem/menuextra/delete/{id}', ['as'=>'admin.menutype.menuitem.menuextra.delete', 'uses'=>'Admin\MenuExtraController@delete']);

	Route::get('/admin/shop', ['as'=>'admin.shop', 'uses'=>'Admin\ShopController@index']);
	Route::get('/admin/shop/add', ['as'=>'admin.shop.add', 'uses'=>'Admin\ShopController@add']);
	Route::post('/admin/shop/save', ['as'=>'admin.shop.save', 'uses'=>'Admin\ShopController@save']);
	Route::get('/admin/shop/edit/{id}', ['as'=>'admin.shop.edit', 'uses'=>'Admin\ShopController@edit']);
	Route::put('/admin/shop/update/{id}', ['as'=>'admin.shop.update', 'uses'=>'Admin\ShopController@update']);
	Route::get('/admin/shop/delete/{id}', ['as'=>'admin.shop.delete', 'uses'=>'Admin\ShopController@delete']);
	Route::get('/admin/shop/shopschedule/{shop_id}', ['as'=>'admin.shop.shopschedule', 'uses'=>'Admin\ShopScheduleController@index']);
	Route::get('/admin/shop/shopschedule/add/{shop_id}', ['as'=>'admin.shop.shopschedule.add', 'uses'=>'Admin\ShopScheduleController@add']);
	Route::post('/admin/shop/shopschedule/save/{shop_id}', ['as'=>'admin.shop.shopschedule.save', 'uses'=>'Admin\ShopScheduleController@save']);
	Route::get('/admin/shop/shopschedule/edit/{id}', ['as'=>'admin.shop.shopschedule.edit', 'uses'=>'Admin\ShopScheduleController@edit']);
	Route::put('/admin/shop/shopschedule/update/{id}', ['as'=>'admin.shop.shopschedule.update', 'uses'=>'Admin\ShopScheduleController@update']);
	Route::get('/admin/shop/shopschedule/delete/{id}', ['as'=>'admin.shop.shopschedule.delete', 'uses'=>'Admin\ShopScheduleController@delete']);

	Route::get('/admin/order', ['as'=>'admin.order', 'uses'=>'Admin\OrderController@index']);
	Route::get('/admin/order/print/{id}', ['as'=>'admin.order.print', 'uses'=>'Admin\OrderController@print']);

	Route::get('/admin/orderhistory', ['as'=>'admin.orderhistory', 'uses'=>'Admin\OrderHistoryController@index']);
	Route::get('/admin/orderhistory/details/{id}', ['as'=>'admin.orderhistory.details', 'uses'=>'Admin\OrderHistoryController@details']);
	Route::get('/admin/orderhistory/orderagain/{id}', ['as'=>'admin.orderhistory.orderagain', 'uses'=>'Admin\OrderHistoryController@orderagain']);
});
