<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sign_up', function () {
    return view('sign_up');
    });

Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard_user', function () {
    return view('user.dashboard_user');
});

Route::get('/membership', function () {
    return view('membership');
});

Route::get('/review_to_pt', function () {
    return view('review_to_pt');
});


// INI ROUTE TRAINER==============================
Route::get('/personal_trainer', function () {
    return view('personal_trainer.personal_trainer');
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
