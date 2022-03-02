<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CocheController;
use App\Http\Controllers\TipocategoriaController;
use App\Http\Controllers\ImagenController;

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
    return view('auth/login');
});

Auth::routes();

Auth::routes(['verify' => true]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('/user', UserController::class);//->except([]);
Route::put('user', [UserController::class, 'userupdate'])->name('user.userupdate');

//Route::resource('/user', [App\Http\Controllers\UserController::class])->name('user');



//Ruta que nos lleva a los controladores de las tablas
//Controladores de categoria
Route::resource('categoria', CategoriaController::class);
//Controladores de coches
Route::resource('coche', CocheController::class);
//Controladores de tipocategoria
Route::resource('tipocategoria', TipocategoriaController::class);
//Controladores de imagenes
Route::resource('imagen', ImagenController::class);

Route::post('imagen/{imagen}', [ImagenController::class, 'upload'])->name('imagen.upload');

//Route::post('imagen/{imagen}', [ImagenController::class, 'upload'])->name('imagen.upload');
Route::get('coche/{coche}/imagen', [CocheController::class, 'imagen'])->name('coche.imagen');

Route::post('coche/{coche}/upload', [CocheController::class, 'upload'])->name('coche.upload');
