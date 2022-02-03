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

use App\Models\Plat;

Route::get('/', function () {
    return view('welcome');
});



/*    testing la connectivitee avec la base de donnees
Route::get('/testing', function () {

        $menu = Plat::find(11);


    return $menu->title;
});
*/
