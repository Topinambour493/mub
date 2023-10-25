<?php

use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\HistoriqueController;
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
    return view('produit');
});
*/

/*Facon controller
Route::get('/',[UserController::class,'catalogue']);
*/

/*Facon ressource
Route::resource('user', UserController::class);
*/

Route::get('/',[ProduitController::class,'catalogue']);

Route::get('/panier',[PanierController::class,'panier'])->name('panier')->middleware('connected');

Route::get('/catalogue',[ProduitController::class,'catalogue'])->name('catalogue');

Route::get('/fiche_produit/{id}',[ProduitController::class,'fiche_produit'])->name('fiche_produit');

Route::get('/inscription',[UtilisateurController::class,'inscription'])->name('inscription')->middleware('guest');

Route::get('/reset',[ResetController::class,'reset'])->name('reset')->middleware('guest');

Route::post('/inscrit',[UtilisateurController::class,'inscrit'])->name('inscrit')->middleware('guest');

Route::get('/nb_users',[UtilisateurController::class,'get_nbUsers'])->middleware('admin');

Route::post('/authentification',[LoginController::class,'authentification'])->name('authentification');

Route::get('/connexion',[UtilisateurController::class,'connexion'])->name('connexion')->middleware('guest');

Route::get('/deconnexion',[UtilisateurController::class,'deconnexion'])->name('deconnexion')->middleware('connected');

Route::post('/ajoutProduit',[ProduitController::class,'ajoutProduit'])->name('ajoutProduit')->middleware('admin');

Route::get('/modification_fiche_produit/{id}', [ProduitController::class, 'modificationFicheProduit'])->name("modification_fiche_produit")->middleware('admin');

Route::post('/changementProduit',[ProduitController::class,'changementProduit'])->name('changementProduit')->middleware('admin');

Route::get('/adminNouveauProduit',[ProduitController::class,'adminNouveauProduit'])->name('adminNouveauProduit')->middleware('admin');

Route::get('/historiqueCommandes',[HistoriqueController::class,'historiqueCommandes'])->name('historique')->middleware('connected');

Route::get('/stats', function () {return view('stats');})->name('stats')->middleware('admin');

Route::get('/biggestpurchase', [PanierController::class, 'biggestpurchase'])->middleware('admin');

Route::get('/nb_commandes', [PanierController::class, 'get_nbCommandes'])->middleware('admin');

Route::post('/ajoutePanier',[PanierController::class, 'ajoutePanier'])->middleware('connected');

Route::post('/validerPanier', [PanierController::class, 'validerlepanier'])->middleware('connected');

Route::post('/enleveStock', [PanierController::class, 'enleveStock'])->middleware('connected');

Route::post('/remetStock', [PanierController::class, 'remetStock'])->middleware('connected');

Route::post('/getStock', [PanierController::class, 'getStock'])->middleware('connected');
