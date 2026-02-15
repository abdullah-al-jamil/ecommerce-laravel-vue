<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.signIn');
});

Route::post('/login_user', [\App\Http\Controllers\auth\AuthController::class, 'loginUser']);


Route::get('/createAdmin', [AuthController::class, 'createCustomer']);
