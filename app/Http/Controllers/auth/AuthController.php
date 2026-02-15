<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    public function loginUser(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'status' => 'errors',
                'errors' => $validation->errors()->first(),
            ]);
        } else {
            
        }
    }   
}
