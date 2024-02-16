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
    return view('welcome');
});
  
//Route::get('lang/home', [LangController::class, 'index']);
Route::get('lang/change/{lang}', [App\Http\Controllers\languagwController::class, 'change'])->name('changeLang');
Route::get('/view', [App\Http\Controllers\languagwController::class, 'index']);
Route::get('/store', [App\Http\Controllers\languagwController::class, 'store']);