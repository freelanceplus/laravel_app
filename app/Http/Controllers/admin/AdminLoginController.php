<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function adminLogin(){
        return view('admin.adminLogin')->with('user_type', 'admin');
    }

    public function postAdminLogin(Request $request){

        session_start();
        if(Auth::guard('admin')->attempt(['email' => $request['email'], 'password' => $request['password']]))
        {
            return redirect()->route('adminDashboard');
        }
        else
            session(['message_admin'=>'Wrong credentials']);
            return redirect()->back();
    }

    public function getLogout(){
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}
