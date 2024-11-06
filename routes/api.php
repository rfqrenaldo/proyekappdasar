<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register',[LoginController::class,'register']);
Route::post('login',[LoginController::class,'login']);

use App\Http\Controllers\ProjectController;

// Route API untuk filter proyek
Route::get('/projects/filter', [ProjectController::class, 'filterProjects'])->name('api.projects.filter');

// Route API untuk pencarian proyek
Route::get('/projects/search', [ProjectController::class, 'searchProjects'])->name('api.projects.search');

