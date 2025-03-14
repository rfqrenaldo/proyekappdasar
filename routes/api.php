<?php
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StakeholderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json(['user' => $request->user()]);
});

// Rute OAuth Google
Route::get('/auth/redirect', [SocialiteController::class, 'redirect']);
Route::get('/auth/google/callback', [SocialiteController::class, 'callback']);

// Rute yang memerlukan otentikasi
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'getAllProjects'])->name('api.projects.list');
    Route::post('/logout', [SocialiteController::class, 'logout']);
});

// Rute untuk registrasi dan login
Route::post('/register', [LoginController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// Rute API proyek
Route::post('/projects/filter', [HomeController::class, 'filterProjects'])->name('api.projects.filter');
Route::get('/projects', [HomeController::class, 'getAllProjects'])->name('api.projects.list');
Route::get('/projects/{id}', [ProjectController::class, 'view_project'])->name('api.projects.view');

// Rute API stakeholder
Route::get('/stakeholders/{id}', [ProjectController::class, 'DetailStakeholder'])->name('api.stakeholders.detail');
Route::get('/stakeholders', [StakeholderController::class, 'view_NavStakeholder'])->name('api.stakeholders.list');
Route::get('/stakeholders/search/{keyword}', [StakeholderController::class, 'searchStakeholder'])->name('api.stakeholders.search');
Route::post('/stakeholders/storeStakeholders', [StakeholderController::class, 'storeStakeholder'])->name('api.stakeholder.store');
Route::put('/stakeholders/updateStakeholders/{id}', [StakeholderController::class, 'updateStakeholder'])->name('api.stakeholder.update');
Route::delete('/stakeholders/deleteStakeholders/{id}', [StakeholderController::class, 'deleteStakeholder'])->name('api.stakeholder.delete');



// Rute API tim dan anggota
Route::get('/teams/{id}', [ProjectController::class, 'DetailTeam'])->name('api.teams.detail');
Route::get('/members/{id}', [ProjectController::class, 'DetailMember'])->name('api.members.detail');


// Rute API mahasiswa
Route::get('/mahasiswa', [MahasiswaController::class, 'view_NavMember'])->name('api.stakeholders.list');
Route::get('/mahasiswa/search/{keyword}', [MahasiswaController::class, 'searchMahasiswa'])->name('api.projects.search');
Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'DetailMahasiswa'])->name('api.members.detail');
Route::post('/mahasiswa/storeMember',[MahasiswaController::class, 'storeMahasiswa'])->name('api.members.store');
Route::put('/mahasiswa/updateMember/{id}', [MahasiswaController::class, 'updateMahasiswa'])->name('api.mahasiswa.update');
Route::delete('/mahasiswa/deleteMember/{id}', [MahasiswaController::class, 'deleteMahasiswa'])->name('api.mahasiswa.delete');

// Rute API pencarian proyek
Route::get('/search/{keyword}', [ProjectController::class, 'searchProjects'])->name('api.projects.search');
