<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }
    public function adminLoginPage(){
        return view('auth.admin-login');
    }
    public function customerLoginPage(){
        return view('customer.login');
    }
    public function logout(){
    $isAdmin = Auth::guard('admin')->check();

    Auth::logout();

    if($isAdmin){
        return redirect()->route('login.admin');
    }

    return redirect()->route('login.customer');
}

}
