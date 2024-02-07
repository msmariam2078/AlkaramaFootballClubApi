<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//player
Route::get('/view/players',[App\Http\Controllers\PlayerController::class,'index']);
Route::post('/view/play/player',[App\Http\Controllers\PlayerController::class,'showByPlay']);
Route::get('/view/player/{uuid}',[App\Http\Controllers\PlayerController::class,'show']);
Route::post('/add/player/',[App\Http\Controllers\PlayerController::class,'store']);
Route::post('/edit/player/{uuid}',[App\Http\Controllers\PlayerController::class,'update']);
Route::get('/remove/player',[App\Http\Controllers\PlayerController::class,'destroy']);
//club
Route::get('/view/clubs',[App\Http\Controllers\ClubController::class,'index']);
Route::post('/add/club',[App\Http\Controllers\ClubController::class,'store']);
Route::post('/edit/club/{uuid}',[App\Http\Controllers\ClubController::class,'update']);
Route::get('/remove/club/{uuid}',[App\Http\Controllers\ClubController::class,'destroy']);
//...match
Route::get('/view/matchs',[App\Http\Controllers\MatchingController::class,'index']);
Route::get('/remove/match/{uuid}',[App\Http\Controllers\MatchingController::class,'destroy']);
Route::get('/view/match/{uuid}',[App\Http\Controllers\MatchingController::class,'show']);
Route::post('/view/date/matchs',[App\Http\Controllers\MatchingController::class,'indexByDate']);
Route::post('/add/match',[App\Http\Controllers\MatchingController::class,'store']);
Route::post('/edit/match/{uuid}',[App\Http\Controllers\MatchingController::class,'update']);
//...replacement
Route::post('/add/replacment/{uuid}',[App\Http\Controllers\ReplacmentController::class,'store']);
Route::post('/edit/replacment/{uuid}',[App\Http\Controllers\ReplacmentController::class,'update']);
Route::get('/remove/replacment/{uuid}',[App\Http\Controllers\ReplacmentController::class,'destroy']);
Route::get('/view/replacment/{uuid}',[App\Http\Controllers\ReplacmentController::class,'show']);
Route::get('/view/replacments',[App\Http\Controllers\ReplacmentController::class,'index']);

//...employee
Route::get('/view',[App\Http\Controllers\EmployeeController::class,'show']);
Route::post('/add/employee',[App\Http\Controllers\EmployeeController::class,'store']);
Route::post('/edit/employee/{uuid}',[App\Http\Controllers\EmployeeController::class,'update']);
Route::get('/delete/employee/{uuid}',[App\Http\Controllers\EmployeeController::class,'destroy']);
//...statistic
Route::post('/add/statistic/{uuid}',[App\Http\Controllers\StatisticController::class,'store']);
Route::post('/edit/statistic/{uuid}',[App\Http\Controllers\StatisticController::class,'update']);
Route::get('/view/statistics/{uuid}',[App\Http\Controllers\StatisticController::class,'index']);
Route::get('/remove/statistic/{uuid}',[App\Http\Controllers\StatisticController::class,'destroy']);

//...information
Route::get('/view/informations',[App\Http\Controllers\InformationController::class,'indexByType']);
Route::get('/view/information/{uuid}',[App\Http\Controllers\InformationController::class,'show']);
Route::post('/add/information/match/{uuid}',[App\Http\Controllers\InformationController::class,'informationMatch']);
Route::post('/add/information/club/{uuid}',[App\Http\Controllers\InformationController::class,'informationClub']);
Route::post('/add/information/session/{uuid}',[App\Http\Controllers\InformationController::class,'informationSession']);
Route::post('/edit/information/{uuid}',[App\Http\Controllers\InformationController::class,'update']);