<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsAPIController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/top-headlines/query/{query}',
[NewsAPIController::class, 'getTopHeadlinesQuery']);
//[NewsAPIService::class, 'getTopHeadlinesQuery']);

Route::get('/top-headlines/todayTop',
[NewsAPIController::class, 'getTodayTopNews']);

Route::get('/everything/query/{query}',
[NewsAPIController::class, 'getEverythingQuery']);

Route::get('/everything/TimeBack/{date}/{stepBack}/{numberBack}',
[NewsAPIController::class, 'getTimeBackNews']);

Route::get('/everything/habrTop',
[NewsAPIController::class, 'getTopHabrTen']);

Route::get('/everything/habrSearch{query}',
[NewsAPIController::class, 'getHabrSearch']);
