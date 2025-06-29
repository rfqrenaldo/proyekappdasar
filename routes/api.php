<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StakeholderController;
use App\Http\Controllers\YearController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('jwt')->get('/user', function (Request $request) {
    $user = $request->user();

    return response()->json([
        'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ],
    ]);
});

// Rute OAuth Google
Route::get('/auth/redirect', [SocialiteController::class, 'redirect']);
Route::get('/auth/google/callback', [SocialiteController::class, 'callback']);

// Rute yang memerlukan otentikasi
Route::middleware(['jwt'])->group(function () {
    // Route::get('/dashboard', [HomeController::class, 'getAllProjects'])->name('api.projects.list');
    Route::post('/logout', [SocialiteController::class, 'logout']);
    Route::post('/projects/{id}/comments', [ProjectController::class, 'commentProject'])->name('api.projects.comment');
    Route::delete('/comments/{comment_id}', [ProjectController::class, 'deleteComment'])->name('api.projects.deleteComment');
    Route::post('/projects/{id}/like', [ProjectController::class, 'likeProject'])->name('api.projects.like');
    Route::get('/projects/{id}/like', [ProjectController::class, 'getLikeStatus'])->name('api.projects.getLikeStatus');
    Route::post('/mahasiswa/storeMember', [MahasiswaController::class, 'storeMahasiswa'])->name('api.members.store');
    Route::put('/mahasiswa/updateMember/{id}', [MahasiswaController::class, 'updateMahasiswa'])->name('api.mahasiswa.update');
    Route::delete('/mahasiswa/deleteMember/{id}', [MahasiswaController::class, 'deleteMahasiswa'])->name('api.mahasiswa.delete');
    Route::post('/mahasiswa/storeTeamMember', [MahasiswaController::class, 'storeTeamMember'])->name('api.members.storeTeamMember');
    Route::put('/mahasiswa/updateTeamMember/{id}', [MahasiswaController::class, 'updateTeamMember'])->name('api.members.updateTeamMember');
    Route::delete('/mahasiswa/deleteTeamMember/{id}', [MahasiswaController::class, 'deleteTeamMember'])->name('api.members.deleteTeamMember');
    Route::post('/projects/storeProject', [ProjectController::class, 'storeProject'])->name('api.projects.store');
    Route::put('/projects/updateProject/{id}', [ProjectController::class, 'updateProject'])->name('api.projects.update');
    Route::delete('/projects/deleteProject/{id}', [ProjectController::class, 'deleteProject'])->name('api.projects.delete');
    Route::post('/stakeholders/storeStakeholders', [StakeholderController::class, 'storeStakeholder'])->name('api.stakeholder.store');
    Route::put('/stakeholders/updateStakeholders/{id}', [StakeholderController::class, 'updateStakeholder'])->name('api.stakeholder.update');
    Route::delete('/stakeholders/deleteStakeholders/{id}', [StakeholderController::class, 'deleteStakeholder'])->name('api.stakeholder.delete');
    Route::get('/year', [YearController::class, 'getYear'])->name('api.year.list');
    Route::get('/year/{id}', [YearController::class, 'getYearDetail'])->name('api.year.detail');
});

// Rute untuk registrasi dan login
Route::post('/register', [LoginController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// Rute API proyek
Route::post('/projects/filter', [HomeController::class, 'filterProjects'])->name('api.projects.filter');
Route::get('/projects', [HomeController::class, 'getAllProjects'])->name('api.projects.list');
Route::get('/projects/{id}', [ProjectController::class, 'DetailProject'])->name('api.projects.detailProject');


Route::get('/projects/{id}/comments', [ProjectController::class, 'getComments'])->name('api.projects.comments');

// Like terkait proyek

Route::get('/projects/{id}/likes', [ProjectController::class, 'getLikes'])->name('api.projects.likes');


// Rute API stakeholder
Route::get('/stakeholders/{id}', [ProjectController::class, 'DetailStakeholder'])->name('api.stakeholders.detail');
Route::get('/stakeholders', [StakeholderController::class, 'view_NavStakeholder'])->name('api.stakeholders.list');
Route::get('/stakeholders/search/{keyword}', [StakeholderController::class, 'searchStakeholder'])->name('api.stakeholders.search');



// Rute API tim dan anggota
Route::get('/teams/{id}', [ProjectController::class, 'DetailTeam'])->name('api.teams.detail');
Route::get('/members/{id}', [ProjectController::class, 'DetailMember'])->name('api.members.detail');


// Rute API mahasiswa
Route::get('/mahasiswa', [MahasiswaController::class, 'view_NavMember'])->name('api.mahasiswa.list');
Route::get('/mahasiswa/search/{keyword}', [MahasiswaController::class, 'searchMahasiswa'])->name('api.mahasiswa.search');
Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'DetailMahasiswa'])->name('api.mahasiswa.detail');

// Rute API pencarian proyek
Route::get('/search/{keyword}', [ProjectController::class, 'searchProjects'])->name('api.projects.search');

//rute API untuk search Team
Route::get('/teams/search/{keyword}', [ProjectController::class, 'searchTeam'])->name('api.teams.search');
