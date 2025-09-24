<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PhaseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\ThemeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get("/login", [UserController::class, "tokenLogin"])->name("login");

Route::post('/register', [UserController::class, 'register']);  // créer un utilisateur
Route::post('/login', [UserController::class, 'login']);        // connexion via email

Route::middleware("auth:sanctum")->group(function () {
    Route::get('/users/{id}', [UserController::class, 'show']);     // voir un utilisateur
    Route::get('/users', [UserController::class, 'index']);         // voir tous les utilisateurs
    Route::put('/users/{id}', [UserController::class, 'update']);   // modifier un utilisateur

    Route::apiResource('phases', PhaseController::class);
    Route::apiResource('themes', ThemeController::class);
    Route::apiResource('questions', QuestionController::class);
    Route::apiResource('options', OptionController::class);
    Route::apiResource('answers', AnswerController::class);


    Route::get('/users/{user_id}/stats/total', [StatController::class, 'userTotal']);
    Route::get('/users/{user_id}/stats/phases/{phase_id}', [StatController::class, 'userByPhase']);
    Route::get('/users/{user_id}/stats/phases', [StatController::class, 'userAllPhases']);

    Route::post("/logout", [UserController::class, "logout"]);
});