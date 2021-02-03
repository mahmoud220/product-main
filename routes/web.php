<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'ShopController@list');

Route::prefix('cart')->group( function() {
    Route::post('/', 'CartController@post')->name('post.cart');
    Route::post('/add-to-cart', 'CartController@addToCart');
    Route::get('/', 'CartController@index');
});

Route::prefix('shop')->group( function() {
    Route::get('/', 'ShopController@list')->name('shop');
    Route::get('/{id}', 'ShopController@get_product')->name('product');
});

Route::prefix('admin')->group( function() {
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@adminLogout')->name('admin.logout');

    Route::get('/categories', 'AdminCategoriesController@list')->name('admin.categories');
    Route::delete('/categories/{id}', 'AdminCategoriesController@delete');
    Route::get('/add-category', 'AdminCategoriesController@showEditForm')->name('add-category');
    Route::get('/edit-category/{id}', 'AdminCategoriesController@showEditForm');
    Route::post('/categories', 'AdminCategoriesController@update');

    Route::get('/products', 'AdminProductsController@list')->name('admin.products');
    Route::delete('/products', 'AdminProductsController@delete')->name('product.delete');
    Route::get('/add-product', 'AdminProductsController@showEditForm')->name('add-product');
    Route::get('/edit-product/{id}', 'AdminProductsController@showEditForm');
    Route::post('/products', 'AdminProductsController@update');
    Route::get('/products/category/{id}', 'AdminProductsController@categoryFilter');

    Route::get('/orders', 'AdminOrdersController@list')->name('admin.orders');
    Route::get('/show-order/{id}', 'AdminOrdersController@showEditForm');
    Route::put('/order', 'AdminOrdersController@update')->name('order.update');
    Route::post('/orders', 'AdminOrdersController@search')->name('order.search');

    Route::get('/users', 'AdminUsersController@list')->name('admin.users');
    Route::get('/edit-user/{id}', 'AdminUsersController@showEditForm');
    Route::put('/user', 'AdminUsersController@update')->name('user.update');
    Route::post('/users', 'AdminUsersController@search')->name('users.search');
    Route::put('/users/', 'AdminUsersController@deleteCart')->name('cart.delete');
});
