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
Route::get('view/players',[App\Http\Controllers\PlayerController::class,'index']);
Route::get('view/play/player',[App\Http\Controllers\PlayerController::class,'showByPlay']);
Route::get('view/player/{uuid}',[App\Http\Controllers\PlayerController::class,'show']);
Route::post('add/player',[App\Http\Controllers\PlayerController::class,'store']);
Route::post('edit/player/{uuid}',[App\Http\Controllers\PlayerController::class,'update']);
Route::get('remove/player/{uuid}',[App\Http\Controllers\PlayerController::class,'destroy']);
//club
Route::get('/view/clubs',[App\Http\Controllers\ClubController::class,'index']);
Route::get('/view/club/{uuid}',[App\Http\Controllers\ClubController::class,'show']);
Route::post('/add/club',[App\Http\Controllers\ClubController::class,'store']);
Route::post('/edit/club/{uuid}',[App\Http\Controllers\ClubController::class,'update']);
Route::get('/remove/club/{uuid}',[App\Http\Controllers\ClubController::class,'destroy']);
//...match
Route::get('/view/matchs',[App\Http\Controllers\MatchingController::class,'index']);
Route::get('/remove/match/{uuid}',[App\Http\Controllers\MatchingController::class,'destroy']);
Route::get('/view/match/{uuid}',[App\Http\Controllers\MatchingController::class,'show']);
Route::get('/view/date/matchs',[App\Http\Controllers\MatchingController::class,'indexByDate']);
Route::get('/view/status/matchs',[App\Http\Controllers\MatchingController::class,'indexByStatus']);
Route::post('/add/match',[App\Http\Controllers\MatchingController::class,'store']);
Route::post('/edit/match/{uuid}',[App\Http\Controllers\MatchingController::class,'update']);
//...replacement
Route::get('/view/match/replacments/{uuid}',[App\Http\Controllers\ReplacmentController::class,'indexByMatch']);
Route::get('/view/replacment/{uuid}',[App\Http\Controllers\ReplacmentController::class,'show']);
Route::post('/add/replacment/{uuid}',[App\Http\Controllers\ReplacmentController::class,'store']);
Route::post('/edit/replacment/{uuid}',[App\Http\Controllers\ReplacmentController::class,'update']);
Route::get('/remove/replacment/{uuid}',[App\Http\Controllers\ReplacmentController::class,'destroy']);


//...employee
Route::get('view/employee/{uuid}',[App\Http\Controllers\EmployeeController::class,'show']);
Route::get('view/employees',[App\Http\Controllers\EmployeeController::class,'index']);
Route::get('view/type/employee',[App\Http\Controllers\EmployeeController::class,'showByType']);
Route::post('add/employee',[App\Http\Controllers\EmployeeController::class,'store']);
Route::post('edit/employee/{uuid}',[App\Http\Controllers\EmployeeController::class,'update']);
Route::get('delete/employee/{uuid}',[App\Http\Controllers\EmployeeController::class,'destroy']);
//...statistic
Route::post('/add/statistic/{uuid}',[App\Http\Controllers\StatisticController::class,'store']);
Route::post('/edit/statistic/{uuid}',[App\Http\Controllers\StatisticController::class,'update']);
Route::get('/view/match/statistics/{uuid}',[App\Http\Controllers\StatisticController::class,'index']);
Route::get('/view/statistic/{uuid}',[App\Http\Controllers\StatisticController::class,'show']);
Route::get('/remove/statistic/{uuid}',[App\Http\Controllers\StatisticController::class,'destroy']);

//...information
Route::get('view/type/informations',[App\Http\Controllers\InformationController::class,'indexByType']);
Route::get('view/information/{uuid}',[App\Http\Controllers\InformationController::class,'show']);
Route::post('add/information/match/{uuid}',[App\Http\Controllers\InformationController::class,'informationMatch']);
Route::post('add/information/club/{uuid}',[App\Http\Controllers\InformationController::class,'informationClub']);
Route::post('add/information/session/{uuid}',[App\Http\Controllers\InformationController::class,'informationSession']);
Route::post('edit/information/{uuid}',[App\Http\Controllers\InformationController::class,'update']);
Route::get('remove/information/{uuid}',[App\Http\Controllers\InformationController::class,'destroy']);


//...boss
Route::get('view/boss',[App\Http\Controllers\BossController::class,'index']);
Route::get('view/boss/{uuid}',[App\Http\Controllers\BossController::class,'show']);
Route::post('add/boss',[App\Http\Controllers\BossController::class,'store']);
Route::post('edit/boss/{uuid}',[App\Http\Controllers\BossController::class,'update']);
Route::get('delete/boss/{uuid}',[App\Http\Controllers\BossController::class,'destroy']);

//...prime
Route::get('/view/prime/{uuid}',[App\Http\Controllers\PrimeController::class,'show']);
Route::get('/view/primes',[App\Http\Controllers\PrimeController::class,'index']);
Route::post('/add/prime',[App\Http\Controllers\PrimeController::class,'store']);
Route::post('/edit/prime/{uuid}',[App\Http\Controllers\PrimeController::class,'update']);
Route::get('/view/type/prime',[App\Http\Controllers\PrimeController::class,'showBytype']);
Route::get('/remove/prime/{uuid}',[App\Http\Controllers\PrimeController::class,'destroy']);
//...plan

Route::post('/add/plan/{uuid}',[App\Http\Controllers\PlanController::class,'store']);
Route::get('/view/match/plans/{uuid}',[App\Http\Controllers\PlanController::class,'indexByMatch']);
Route::get('/view/plan/{uuid}',[App\Http\Controllers\PlanController::class,'show']);
Route::post('/edit/plan/{uuid}',[App\Http\Controllers\PlanController::class,'update']);
Route::get('/remove/plan/{uuid}',[App\Http\Controllers\PlanController::class,'destroy']);
//session
Route::get('/view/sessions/',[App\Http\Controllers\SessionController::class,'index']);
Route::get('/view/session/{uuid}',[App\Http\Controllers\SessionController::class,'show']);
Route::post('/add/session',[App\Http\Controllers\SessionController::class,'store']);
Route::post('/edit/session/{uuid}',[App\Http\Controllers\SessionController::class,'update']);
Route::get('/remove/sessions/{uuid}',[App\Http\Controllers\SessionController::class,'destroy']);
//sport
Route::get('/view/sports',[App\Http\Controllers\SportController::class,'index']);
Route::post('/add/sport',[App\Http\Controllers\SportController::class,'store']);
Route::post('/edit/sport/{uuid}',[App\Http\Controllers\SportController::class,'update']);
Route::get('/view/sport/{uuid}',[App\Http\Controllers\SportController::class,'show']);
Route::get('/remove/sport/{uuid}',[App\Http\Controllers\SportController::class,'destroy']);

//wear
Route::get('/view/wears',[App\Http\Controllers\WearController::class,'index']);
Route::get('/view/session/wears',[App\Http\Controllers\WearController::class,'showBySession']);
Route::post('/add/wear',[App\Http\Controllers\WearController::class,'store']);
Route::post('/edit/wear/{uuid}',[App\Http\Controllers\WearController::class,'update']);
Route::get('/remove/wear/{uuid}',[App\Http\Controllers\WearController::class,'destroy']);

//video..
Route::post('/add/club/video/{uuid}',[App\Http\Controllers\VideoController::class,'clubVideo']);
Route::post('/edit/video/{uuid}',[App\Http\Controllers\VideoController::class,'update']);
Route::post('/add/match/video/{uuid}',[App\Http\Controllers\VideoController::class,'matchVideo']);
Route::post('/add/association/video/{uuid}',[App\Http\Controllers\VideoController::class,'associationVideo']);
Route::get('/remove/video/{uuid}',[App\Http\Controllers\VideoController::class,'destroy']);
//...boss
Route::get('/view/boss',[App\Http\Controllers\BossController::class,'index']);
Route::get('/view/boss/{uuid}',[App\Http\Controllers\BossController::class,'show']);
Route::post('/add/boss',[App\Http\Controllers\BossController::class,'store']);
Route::post('/edit/boss/{uuid}',[App\Http\Controllers\BossController::class,'update']);
Route::get('/delete/boss/{uuid}',[App\Http\Controllers\BossController::class,'destroy']);
//  Association
Route::get('/association/view',[App\Http\Controllers\AssociationController::class,'index']);
Route::get('/association/view/{uuid}',[App\Http\Controllers\AssociationController::class,'show']);
Route::post('/association/add',[App\Http\Controllers\AssociationController::class,'store']);
Route::post('/edit/{uuid}',[App\Http\Controllers\AssociationController::class,'update']);
Route::get('/association/remove/{uuid}',[App\Http\Controllers\AssociationController::class,'destroy']);
// Routes of Topfans
Route::get('/Topfans/view',[App\Http\Controllers\TopfanController::class,'index']);
Route::get('/Topfan/view/{uuid}',[App\Http\Controllers\TopfanController::class,'show']);
Route::post('/Topfan/add',[App\Http\Controllers\TopfanController::class,'store']);
Route::post('/Topfan/edit/{uuid}',[App\Http\Controllers\TopfanController::class,'update']);
Route::get('/Topfan/remove/{uuid}',[App\Http\Controllers\TopfanController::class,'destroy']);
//standing
Route::post('/add/standing',[App\Http\Controllers\StandingController::class,'store']);

Route::post('/edit/standing/{uuid}',[App\Http\Controllers\StandingController::class,'update']);

Route::get('/view/standing',[App\Http\Controllers\StandingController::class,'index']);
Route::get('/remove/standing/{uuid}',[App\Http\Controllers\StandingController::class,'destroy']);