<?php

use App\Models\Menu;
use App\Models\Plat;
use App\Models\User;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Models\Accompagnement;
use App\Http\Resources\LikeResource;
use App\Http\Resources\MenuResource;
use App\Http\Resources\PlatResource;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\ClientResource;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PlatController;
use App\Http\Resources\CommandeResource;
use App\Http\Resources\RestaurantResource;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\RestaurantController;
use App\Http\Resources\AccompagnementResource;
use App\Http\Controllers\AccompagnementController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\StatisticController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



    Route::middleware('cors')->group(function () {

        Route::resource('menus', MenuController::class)->only([
            'index', 'store', 'show'
        ]);
        Route::resource('restaurants', RestaurantController::class)->only([
            'index', 'store', 'show'
        ]);
        Route::resource('accompagnements', AccompagnementController::class)->only([
            'index', 'store', 'show'
        ]);
        Route::resource('plats', PlatController::class)->only([
            'index', 'store', 'show'
        ]);
        Route::resource('commandes', CommandeController::class)->only([
            'index', 'store', 'show'
        ]);
        Route::resource('likes', LikeController::class)->only([
            'index', 'store', 'show'
        ]);
        Route::resource('reclamations', ReclamationController::class)->only([
            'index', 'store', 'show'
        ]);
        Route::get('/statistics', [StatisticController::class, 'statistics']);
    });
});
Route::post('/login', [AuthController::class, 'signin'])->name('login');
Route::post('/register', [AuthController::class, 'signup'])->name('register');
Route::post('/restaurant-register', [AuthController::class, 'signupRestaurant'])->name('restaurant-register');
Route::get('/test', function (Request $request) {

    return LikeResource::collection(Client::find(1)->likes()->get());
});
