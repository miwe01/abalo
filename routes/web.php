<?php

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

Route::get('/', function () {
    return view('m2_menue');
});

Route::get('/testdata', [\App\Http\Controllers\AbTestDataController::class, 'index']);


Route::group(['middleware' => ['web']], function () {
    // artikel verkaufen
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::get('/login2', [App\Http\Controllers\AuthController::class, 'login2'])->name('login2');

    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isloggedin'])->name('haslogin');

    Route::get('/articles/{id}/sold', [\App\Http\Controllers\ArticlesController::class, 'sellArticle_api']);

    // Artikeleingabe Vue
    Route::get('artikeleingabe', [\App\Http\Controllers\ArticlesController::class, 'viewNewSite']);
    Route::get('eingeloggterBenutzer', [\App\Http\Controllers\ArticlesController::class, 'eingeloggterBenutzerID']);

    Route::get('/checkAktuellenBenutzer', [\App\Http\Controllers\ArticlesController::class, 'checkAktuellenBenutzer']);

});



Route::get('/articles', [App\Http\Controllers\ArticlesController::class, 'search']);
Route::get('/menue', function(){
   return view('m2_menue');
});

Route::get('/newarticle', [\App\Http\Controllers\ArticlesController::class, 'insertArticle']);
Route::post('/newarticle', [\App\Http\Controllers\ArticlesController::class, 'insertArticleAjax']);

// add a Shoppingcart
Route::get('/articles/newShoppingCart', [\App\Http\Controllers\ShoppingCartController::class, 'addShoppingCart']);


// Add item to shopping cart
Route::post('/api/shoppingcart', [\App\Http\Controllers\ShoppingCartController::class, 'addShoppingCartItem_api']);

//remove Item from shopping cart
Route::delete('/api/shoppingcart/{shoppingcartid}/articles/{articleId}', [\App\Http\Controllers\ShoppingCartController::class, 'removeShoppingCartItem_api']);

// API Aufruf

Route::get('/api/article', [\App\Http\Controllers\ArticlesController::class, 'index']);

Route::get('/api/addArticles/', [\App\Http\Controllers\ArticlesController::class, 'addArticle']);



// New Site
Route::get('/newsite', [\App\Http\Controllers\ArticlesController::class, 'newSite']);


