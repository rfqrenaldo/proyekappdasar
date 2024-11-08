<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StakeholderController;
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

// Route API untuk registrasi dan login
Route::post('register', [LoginController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

// Route API untuk filter proyek
Route::get('/projects/filter', [HomeController::class, 'filterProjects'])->name('api.projects.filter');

// Route API untuk pencarian proyek
Route::get('/projects/search', [ProjectController::class, 'searchProjects'])->name('api.projects.search');

// Route API untuk melihat detail proyek
Route::get('/projects/{id}', [ProjectController::class, 'view_project'])->name('api.projects.view');

// Route API untuk melihat detail stakeholder beserta proyek terkait
Route::get('/stakeholders/{id}', [ProjectController::class, 'DetailStakeholder'])->name('api.stakeholders.detail');

// Route API untuk melihat semua stakeholder (dari StakeholderController)
Route::get('/stakeholders', [StakeholderController::class, 'view_NavStakeholder'])->name('api.stakeholders.list');

// Route API untuk melihat detail tim beserta anggota
Route::get('/teams/{id}', [ProjectController::class, 'DetailTeam'])->name('api.teams.detail');

// Route API untuk melihat detail anggota tim beserta proyek terkait
Route::get('/members/{id}', [ProjectController::class, 'DetailMember'])->name('api.members.detail');
