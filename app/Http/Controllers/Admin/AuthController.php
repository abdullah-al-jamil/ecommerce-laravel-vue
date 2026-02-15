<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function createCustomer()
    {
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@gmail.com';
        $user->password = Hash::make('1234');
        $user->save();

        $role = Role::where('slug', 'admin')->first();
        $user->roles()->attach($role);
    }
}
