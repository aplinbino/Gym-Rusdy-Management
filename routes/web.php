<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/membership', function () {
    return view('membership');
});

Route::get('/sign_up', function () {
    return view('sign_up');
});
