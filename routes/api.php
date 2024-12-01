<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StakeholderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route untuk mendapatkan data user yang sedang login
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route API untuk registrasi dan login
Route::post('/register', [LoginController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// Route API untuk filter proyek berdasarkan kategori dan tahun
Route::post('/projects/filter', [HomeController::class, 'filterProjects'])->name('api.projects.filter');

// Route API untuk melihat semua proyek
Route::get('/projects', [HomeController::class, 'getAllProjects'])->name('api.projects.list');

// Route API untuk melihat detail proyek berdasarkan ID
Route::get('/projects/{id}', [ProjectController::class, 'view_project'])->name('api.projects.view');

// Route API untuk melihat detail stakeholder beserta proyek terkait
Route::get('/stakeholders/{id}', [ProjectController::class, 'DetailStakeholder'])->name('api.stakeholders.detail');

// Route API untuk melihat semua stakeholder
Route::get('/stakeholders', [StakeholderController::class, 'view_NavStakeholder'])->name('api.stakeholders.list');

// Route API untuk search stakeholder berdasarkan nama atau nama proyek
Route::get('/stakeholders/search/{keyword}', [StakeholderController::class, 'searchStakeholder'])->name('api.stakeholders.search');

// Route API untuk melihat detail tim beserta anggota
Route::get('/teams/{id}', [ProjectController::class, 'DetailTeam'])->name('api.teams.detail');

// Route API untuk melihat detail anggota tim beserta proyek terkait
Route::get('/members/{id}', [ProjectController::class, 'DetailMember'])->name('api.members.detail');

//Route API untuk melihat semua member atau mahasiswa
Route::get('/mahasiswa', [MahasiswaController::class, 'view_NavMember'])->name('api.stakeholders.list');

//Route API untuk search di navbar mahasiswa
Route::get('/mahasiswa/search/{keyword}', [MahasiswaController::class, 'searchMahasiswa'])->name('api.projects.search');

//Route API untuk melihat detail mahasiswa
Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'DetailMahasiswa'])->name('api.members.detail');

// Route API untuk search
Route::get('/search/{keyword}', [ProjectController::class, 'searchProjects'])->name('api.projects.search');
