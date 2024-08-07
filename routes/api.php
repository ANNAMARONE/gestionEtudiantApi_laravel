<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EvaluationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('/etudiant', [EtudiantController::class, 'index']);
    Route::post('/createEtudiant', [EtudiantController::class, 'store']);
    Route::post('etudiants/{id}', [EtudiantController::class, 'update']);
    Route::delete('/Etudiant/{id}', [EtudiantController::class, 'destroy']);
    
    Route::post('/Note', [EvaluationController::class, 'store']);
    Route::delete('/note/{id}', [EvaluationController::class, 'destroy']);
    Route::post('updateNotes/{id}', [EvaluationController::class, 'update']);
    Route::get('/notes/{id}', [EvaluationController::class, 'index']);
});

// Routes pour l'authentification
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});
