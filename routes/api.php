<?php

use App\Http\Controllers\Api\V1\LeaderBordController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/users', [UserController::class, 'store']);
Route::post('/users/{userId}', [LeaderBordController::class, 'addPoints']);
Route::get('/leaderboard/top', [LeaderBordController::class, 'top']);
Route::get('/leaderboard/rank/{userId}', [LeaderBordController::class, 'rank']);
