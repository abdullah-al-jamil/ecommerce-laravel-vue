<?php

use App\Http\Controllers\Admin\AuthController;

Route::get('/dashboard', function () {
    return view('admin.index');
});