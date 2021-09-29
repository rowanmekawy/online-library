<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;


class adminController extends Controller

{
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    //         $this->middleware('guest:admin')->except('logout');
    // }
    public function loginview()
    {
        return view('admin-login');
    }  
      

    public function adminLogin(Request $request)
    { 
            $data = $request -> all();
        if (Auth:: guard('admin')-> attempt(['email' => $data['email'], 'password' => $data['password']]))
        {
            Session::put('admin',$data['email']);
            return redirect()->route('admin-dashboard');
        }

        else{
           return redirect()->back();
            // echo "error";
        }

    }

}
