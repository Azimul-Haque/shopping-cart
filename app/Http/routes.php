<?php

Route::get('/clearcart', [
    'uses' => 'ProductController@clearSession',
    'as' => 'product.clearsession'
]);

Route::get('/clear', [
    'uses' => 'ProductController@clear',
    'as' => 'product.clear'
]);

Route::get('/', [
    'uses' => 'ProductController@getIndex',
    'as' => 'product.index'
]);

Route::get('/category/{id}/{random_string}', [
    'uses' => 'ProductController@getCategoryWise',
    'as' => 'product.categorywise'
]);

Route::get('/subcategory/{id}/{random_string}', [
    'uses' => 'ProductController@getSubcategoryWise',
    'as' => 'product.subcategorywise'
]);

Route::get('/product/{id}/{random_string}', [
    'uses' => 'ProductController@getSingleProduct',
    'as' => 'product.getsingleproduct'
]);

Route::get('/product/add/to/wishlist/{product_id}/{user_id}', [
    'uses' => 'ProductController@addProductToWishList',
    'as' => 'product.addtowishlist'
]);

Route::get('/about', [
    'uses' => 'ProductController@getAbout',
    'as' => 'index.about'
]);

Route::get('/contact', [
    'uses' => 'ProductController@getContact',
    'as' => 'index.contact'
]);

Route::post('/send/message', [
    'uses' => 'ProductController@postContactMessage',
    'as' => 'index.postcontactmessage'
]);

Route::get('/privacy', [
    'uses' => 'ProductController@getPrivacy',
    'as' => 'index.privacy'
]);

Route::get('/terms', [
    'uses' => 'ProductController@getTerms',
    'as' => 'index.terms'
]);

Route::get('/search', [
    'uses' => 'ProductController@search',
    'as' => 'product.search'
]);
Route::get('/autocomplete', [
    'uses' => 'ProductController@autocpmplete',
    'as' => 'product.autocpmplete'
]);

Route::get('/register', [
    'uses' => 'UserController@getRegister',
    'as' => 'user.register',
    'middleware' => 'guest'
]);

Route::post('/register', [
    'uses' => 'UserController@postRegister',
    'as' => 'user.register',
    'middleware' => 'guest'
]);

Route::get('/login', [
    'uses' => 'UserController@getLogin',
    'as' => 'user.login',
    'middleware' => 'guest'
]);

Route::post('/login', [
    'uses' => 'UserController@postLogin',
    'as' => 'user.login',
    'middleware' => 'guest'
]);

Route::get('/logout', [
    'uses' => 'UserController@getLogout',
    'as' => 'user.logout',
    'middleware' => 'auth'
]);

Route::get('user/profile/{unique_key}', [
    'uses' => 'UserController@getProfile',
    'as' => 'user.profile',
    'middleware' => 'auth'
]);

Route::put('user/profile/update/{id}', [
    'uses' => 'UserController@updateProfile',
    'as' => 'profile.update',
    'middleware' => 'auth'
]);

Route::get('article/{slug}', [
    'uses' => 'ProductController@getSinglePage',
    'as' => 'index.article'
]);

/*warehouse routes*/
/*warehouse routes*/
Route::get('/dashboard', [
    'uses' => 'WarehouseController@getDashboard',
    'as' => 'warehouse.dashboard',
    'middleware' => 'admin'
]);

Route::get('/warehouse/categories', [
    'uses' => 'WarehouseController@getCategories',
    'as' => 'warehouse.categories',
    'middleware' => 'admin'
]);

Route::post('/warehouse/categories', [
    'uses' => 'WarehouseController@postCategories',
    'as' => 'warehouse.categories',
    'middleware' => 'admin'
]);

Route::post('/warehouse/subcategories', [
    'uses' => 'WarehouseController@postSubcategories',
    'as' => 'warehouse.subcategories',
    'middleware' => 'admin'
]);

Route::get('/warehouse/products', [
    'uses' => 'WarehouseController@getAddProduct',
    'as' => 'warehouse.products',
    'middleware' => 'admin'
]);

Route::get('/warehouse/products/subcategory/{subcat}', [
    'uses' => 'WarehouseController@getProductSubCat',
    'as' => 'warehouse.getsubcategorywise',
    'middleware' => 'admin'
]);

Route::get('/warehouse/products/search/{search_param}', [
    'uses' => 'WarehouseController@searchProducts',
    'as' => 'warehouse.searchproduct',
    'middleware' => 'admin'
]);

Route::post('/warehouse/product/store', [
    'uses' => 'WarehouseController@postAddProduct',
    'as' => 'warehouse.addproduct',
    'middleware' => 'admin'
]);

Route::get('/warehouse/edit/product/{id}/{random_string}', [
    'uses' => 'WarehouseController@getEditProduct',
    'as' => 'warehouse.geteditproduct',
    'middleware' => 'admin'
]);

Route::put('/warehouse/edit/product/{id}', [
    'uses' => 'WarehouseController@putEditProduct',
    'as' => 'warehouse.editproduct',
    'middleware' => 'admin'
]);

Route::put('/warehouse/unavailableproduct/{id}', [
    'uses' => 'WarehouseController@putUnavailableProduct',
    'as' => 'warehouse.unavailableproduct',
    'middleware' => 'admin'
]);

Route::get('/warehouse/getdueorders/api', [
    'uses' => 'WarehouseController@getDueOrdersApi',
    'as' => 'warehouse.getdueordersapi',
    'middleware' => 'admin'
]);

Route::get('/warehouse/dueorders', [
    'uses' => 'WarehouseController@getDueOrders',
    'as' => 'warehouse.dueorders',
    'middleware' => 'admin'
]);

Route::get('/warehouse/deliveredorders', [
    'uses' => 'WarehouseController@getDeliveredOrders',
    'as' => 'warehouse.deliveredorders',
    'middleware' => 'admin'
]);
Route::get('/receipt/pdf/{payment_id}/{random_string}', [ 'uses' => 'WarehouseController@getReceitPDF', 'as' => 'warehouse.receiptpdf']);

Route::put('/warehouse/confirmorder/{id}', [
    'uses' => 'WarehouseController@putConfirmOrder',
    'as' => 'warehouse.confirmorder',
    'middleware' => 'admin'
]);

Route::get('/warehouse/customers', [
    'uses' => 'WarehouseController@getCustomers',
    'as' => 'warehouse.customers',
    'middleware' => 'admin'
]);
/*warehouse routes*/
/*warehouse routes*/

/*admin activity routes*/
/*admin activity routes*/
Route::get('/admin/settings', [
    'uses' => 'AdminController@getSettings',
    'as' => 'admin.settings',
    'middleware' => 'admin'
]);
Route::get('/admin/settings/slider/create', [
    'uses' => 'AdminController@getCreateSlider',
    'as' => 'admin.createslider',
    'middleware' => 'admin'
]);
Route::post('/admin/settings/slider/store', [
    'uses' => 'AdminController@storeSlider',
    'as' => 'admin.storeslider',
    'middleware' => 'admin'
]);
Route::get('/admin/settings/slider/{id}/edit', [
    'uses' => 'AdminController@getEditSlider',
    'as' => 'admin.editslider',
    'middleware' => 'admin'
]);
Route::put('/admin/settings/slider/{id}/update', [
    'uses' => 'AdminController@updateSlider',
    'as' => 'admin.updateslider',
    'middleware' => 'admin'
]);
Route::put('/admin/settings/setting/{id}/update', [
    'uses' => 'AdminController@updateSetting',
    'as' => 'admin.updatesetting',
    'middleware' => 'admin'
]);
Route::delete('/admin/settings/slider/{id}/delete', [
    'uses' => 'AdminController@deleteSlider',
    'as' => 'admin.deleteslider',
    'middleware' => 'admin'
]);

Route::get('/admin/pages', [
    'uses' => 'AdminController@getPages',
    'as' => 'admin.pages',
    'middleware' => 'admin'
]);
Route::get('/admin/settings/page/create', [
    'uses' => 'AdminController@getCreatePage',
    'as' => 'admin.createpage',
    'middleware' => 'admin'
]);
Route::post('/admin/settings/page/store', [
    'uses' => 'AdminController@storePage',
    'as' => 'admin.storepage',
    'middleware' => 'admin'
]);
Route::get('/admin/settings/page/{id}/edit', [
    'uses' => 'AdminController@getEditPage',
    'as' => 'admin.editpage',
    'middleware' => 'admin'
]);
Route::put('/admin/settings/page/{id}/update', [
    'uses' => 'AdminController@updatePage',
    'as' => 'admin.updatepage',
    'middleware' => 'admin'
]);
Route::delete('/admin/settings/page/{id}/delete', [
    'uses' => 'AdminController@deletePage',
    'as' => 'admin.deletepage',
    'middleware' => 'admin'
]);
Route::get('/admin/admins', [
    'uses' => 'AdminController@getAdmins',
    'as' => 'admin.admins',
    'middleware' => 'admin'
]);
Route::get('/admin/settings/admin/create', [
    'uses' => 'AdminController@getCreateAdmin',
    'as' => 'admin.createadmin',
    'middleware' => 'admin'
]);
Route::post('/admin/settings/admin/store', [
    'uses' => 'AdminController@storeAdmin',
    'as' => 'admin.storeadmin',
    'middleware' => 'admin'
]);
Route::get('/admin/settings/admin/{id}/edit', [
    'uses' => 'AdminController@editAdmin',
    'as' => 'admin.editadmin',
    'middleware' => 'admin'
]);
Route::put('/admin/settings/admin/{id}/update', [
    'uses' => 'AdminController@updateAdmin',
    'as' => 'admin.updateadmin',
    'middleware' => 'admin'
]);
Route::delete('/admin/settings/admin/{id}/delete', [
    'uses' => 'AdminController@deleteAdmin',
    'as' => 'admin.deleteadmin',
    'middleware' => 'admin'
]);
/*admin activity routes*/
/*admin activity routes*/


Route::get('/addtocart/{id}', [
    'uses' => 'ProductController@getAddToCart',
    'as' => 'product.addtocart'
]);

Route::get('/addtocartsingle/{id}/{qty}', [
    'uses' => 'ProductController@getAddToCartSingle',
    'as' => 'product.addtocartsingle'
]);

Route::get('/add/{id}', [
    'uses' => 'ProductController@getAddByOne',
    'as' => 'product.addbyone'
]);

Route::get('/reduce/{id}', [
    'uses' => 'ProductController@getReduceByOne',
    'as' => 'product.reducebyone'
]);

Route::get('/removeitem/{id}', [
    'uses' => 'ProductController@getRemoveItem',
    'as' => 'product.removeitem'
]);

Route::get('/shoppingcart', [
    'uses' => 'ProductController@getCart',
    'as' => 'product.shoppingcart'
]);

Route::get('/checkout', [
    'uses' => 'ProductController@getCheckout',
    'as' => 'product.checkout',
    'middleware' => 'auth'
]);

Route::post('/checkout', [
    'uses' => 'ProductController@postCheckout',
    'as' => 'product.checkout',
    'middleware' => 'auth'
]);

Route::get('/testmail/{payment_id}', [
    'uses' => 'ProductController@testMail',
    'as' => 'product.testmail',
    'middleware' => 'auth'
]);

Route::get('/sitemap', [
    'uses' => 'ProductController@generateSiteMap',
    'as' => 'index.sitemap',
    'middleware' => 'auth'
]);

// Password Reset Routes...
Route::get('password/reset/{token?}', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@showResetForm']);
Route::post('password/email', ['as' => 'auth.password.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
Route::post('password/reset', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@reset']);
Route::get('/home', ['as'=>'index.homeadhoc','uses'=>'ProductController@getIndexAdhoc']); // reset password redirect adhoc solve
