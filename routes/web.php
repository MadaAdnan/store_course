<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// get => index ,create, edit, show
// put , putch => update
// delete => destroy
//Route::get('users',[\App\Http\Controllers\Api\UserController::class,'index']);
//
//Route::get('users/{user}',[\App\Http\Controllers\Api\UserController::class,'show']);
//Route::get('users/{user}/edit',[\App\Http\Controllers\Api\UserController::class,'show']);
//Route::put('users/{user}/update',[\App\Http\Controllers\Api\UserController::class,'update']);

//Route::resource('users',\App\Http\Controllers\Api\UserController::class);
Route::get('/home',function(){
    return "Home";
})->middleware(\App\Http\Middleware\UserMiddleware::class)->name('home');


Route::resource('users',\App\Http\Controllers\HomeController::class);
