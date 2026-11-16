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
    return view('dashboar_user');
});

Route::get('/membership', function () {
    return view('membership');
});

Route::get('/dashboard_personal_trainer', function () {
    return view('dashboard_personal_trainer');
});

Route::get('/dashboard_admin', function () {
    return view('dashboard_admin');
});