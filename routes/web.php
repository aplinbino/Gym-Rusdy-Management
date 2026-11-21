<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminPtController;
use App\Http\Controllers\DashboardUserController;
 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sign_up', function () {
    return view('sign_up');
    });

Route::get('/login', function () {
    return view('login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard_user', [DashboardUserController::class, 'index'])
        ->name('user.dashboard_user');

    Route::post('/member/jadwal', [DashboardUserController::class, 'storeSchedule'])
        ->name('member.schedule.store');

});

Route::get('/membership', function () {
    return view('user.membership');
});

Route::get('/review_to_pt', function () {
    return view('user.review_to_pt');
});


// INI ROUTE TRAINER==============================
Route::get('/personal-trainer', function () {
    return view('personal_trainer.personal-trainer');
});

Route::get('/schedule', function () {
    return view('personal_trainer.schedule');
});


//INI ROUTE ADMIN=========================
Route::get('/tabel_user', function () {
    return view('admin.tabel_user');
});
Route::get('/tabel_pt', function () {
    return view('admin.tabel_pt');
});
Route::get('/tabel_schedule', function () {
    return view('admin.tabel.schedule');
});
Route::get('/tabel_transaction', function () {
    return view('admin.tabel_transaction');
});

Route::get('/login-with-role', function () {
    return view('login_with_role');
});

Route::get('/sign_up', function () {
    return view('sign_up');
});

Route::post('/sign_up', [AuthController::class, 'signUp'])
    ->name('sign_up.store');

// Login Member
Route::post('/login', [LoginController::class, 'loginMember'])
    ->name('login.member');

// Login Admin dan PT
Route::post('/login-with-role', [LoginController::class, 'loginStaff'])
    ->name('login.staff');

// Proses logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

    // PRoses login member
Route::post('/login', [LoginController::class, 'loginMember'])
    ->name('login.member');

    // CRUD PERSONAL TRAINER
Route::get('/admin/pt', [AdminPtController::class, 'index'])
    ->name('admin.pt.index');

Route::post('/admin/pt', [AdminPtController::class, 'store'])
    ->name('admin.pt.store');

Route::put('/admin/pt/{pt}', [AdminPtController::class, 'update'])
    ->name('admin.pt.update');

Route::delete('/admin/pt/{pt}', [AdminPtController::class, 'destroy'])
    ->name('admin.pt.destroy');
