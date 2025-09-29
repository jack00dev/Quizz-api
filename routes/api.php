<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PhaseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\ThemeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get("/login", [AuthController::class, "tokenLogin"])->name("login");

Route::post('/register', [AuthController::class, 'register']);  // créer un utilisateur
Route::post('/login', [AuthController::class, 'login']);        // connexion via email


Route::apiResource('phases', PhaseController::class);
Route::apiResource('themes', ThemeController::class);
Route::apiResource('questions', QuestionController::class);
Route::apiResource('options', OptionController::class);

Route::get('/users/{id}', [UserController::class, 'show']);     // voir un utilisateur
Route::get('/users', [UserController::class, 'index']);         // voir tous les utilisateurs
Route::put('/users/{id}', [UserController::class, 'update']);   // modifier un utilisateur
Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::apiResource('answers', AnswerController::class);
Route::get('/answers/user/{user_id}', [AnswerController::class, 'getUserAnswers']);


Route::prefix('users/{user_id}/stats')->group(function () {
    Route::get('/total', [StatController::class, 'userTotal']);               // Score global
    Route::get('/phases', [StatController::class, 'userAllPhases']);          // Tous les scores par phase
    Route::get('/phases/{phase_id}', [StatController::class, 'userByPhase']); // Score pour une phase spécifique
});


Route::middleware("auth:sanctum")->group(function () {




    Route::post("/logout", [AuthController::class, "logout"]);
});