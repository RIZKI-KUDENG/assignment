<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService{
    public function login($username, $password){
        $user = User::where('username', $username)->first();
        if(!$user) return null;
        if(!Hash::check($password, $user->password)) return null;

        Auth::login($user);
        return $user;
    }
}