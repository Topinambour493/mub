<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopBasketController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;


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

/*Facon tres simple
Route::get('/prod', function () {
    return view('product');
});
*/

/*Facon controller
Route::get('/',[UserController::class,'catalog']);
*/

/*Facon ressource
Route::resource('user', UserController::class);
*/

Route::get('/',[ProductController::class, 'catalog']);

Route::get('/shopBasket',[ShopBasketController::class, 'shopBasket'])->name('shopBasket')->middleware('connected');

Route::get('/catalog',[ProductController::class, 'catalog'])->name('catalog');

Route::get('/productSheet/{id}',[ProductController::class, 'productSheet'])->name('productSheet');

Route::get('/inscription',[UserController::class, 'register'])->name('inscription')->middleware('guest');

Route::post('/inscrit',[UserController::class, 'registered'])->name('inscrit')->middleware('guest');

Route::get('/nb_users',[UserController::class, 'getNumberUser'])->middleware('admin');

Route::post('/authentification',[LoginController::class,'authentification'])->name('authentification');

Route::get('/connexion',[UserController::class, 'login'])->name('connexion')->middleware('guest');

Route::get('/deconnexion',[UserController::class, 'disconnect'])->name('deconnexion')->middleware('connected');

Route::post('/addProduct',[ProductController::class, 'addProduct'])->name('addProduct')->middleware('admin');

Route::get('/modificationProductSheet/{id}', [ProductController::class, 'modificationProductSheet'])->name("modificationProductSheet")->middleware('admin');

Route::post('/changeProduct',[ProductController::class, 'changeProduct'])->name('changeProduct')->middleware('admin');

Route::get('/adminNewProduct',[ProductController::class,'adminNewProduct'])->name('adminNewProduct')->middleware('admin');

Route::get('/historyOrders',[HistoryController::class, 'orderHistory'])->name('history')->middleware('connected');

Route::get('/stats', function () {return view('stats');})->name('stats')->middleware('admin');

Route::get('/biggestPurchase', [ShopBasketController::class, 'biggestPurchase'])->middleware('admin');

Route::get('/getNumberOrder', [ShopBasketController::class, 'getNumberOrder'])->middleware('admin');

Route::post('/addShopBasket',[ShopBasketController::class, 'addShopBasket'])->middleware('connected');

Route::post('/validateShopBasket', [ShopBasketController::class, 'validateShopBasket'])->middleware('connected');

Route::post('/enleveStock', [ShopBasketController::class, 'removeStock'])->middleware('connected');

Route::post('/remetStock', [ShopBasketController::class, 'restock'])->middleware('connected');

Route::post('/getStock', [ShopBasketController::class, 'getStock'])->middleware('connected');
