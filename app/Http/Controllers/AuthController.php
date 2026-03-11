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
        return view('admin.login');
    }
    public function customerLoginPage(){
        return view('customer.login');
    }
    public function login(Request $request){
        $user = $this->authService->login(
            $request->username,
            $request->password
        );
        if(!$user) return back()->with("error", "Invalid username or password");

        if($user->role == "admin"){
            return redirect()->route("admin.dashboard");
        }
        return redirect()->route("customer.dashboard");
    }
    public function logout(){
        Auth::logout();
        return redirect()->route("product");
    }

}
