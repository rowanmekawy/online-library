<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\book;
use Illuminate\Support\Facades\Auth;
use App\Model\admin\admin;

class PostController extends Controller
{
    
    // public function __construct()
    // {
    //   $this->middleware('auth'); //If user is not logged in then he can't access this page
    // }

    // public function edit($id)
    // {
    //     $users = admin::find(Auth::user()->id);
    //     return view('my-account',compact('users'));
    // }

    public function login()
    {
        return view('login');
    }  
      

    public function customLogin(Request $request)
    {   
        $data = $request -> all();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']]))
        {
            Session::put('user',$data['email']);
            request()->session()->flash('success','Successfully login');
            return redirect()->route('my-account');
        }

        else{
            // request()->session()->flash('error','Invalid email and password pleas try again!');
            return redirect()->back();
            //echo "error";
        }

    }

    



    public function register()
    {
        return view('register');
    }
      

    public function customRegistration(Request $request)
    {  
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        // $data = $request->all();
        // $check = $this->create($data);
        $data=$request->all();
        $data['password']=Hash::make($request->password);
        $status=user::create($data);
        Session::put('user',$data['email']);
        Auth::login($status);
         if($status){
              Session::put('user',$data['email']);
            request()->session()->flash('success','Successfully login');
            return redirect()->route('my-account');
            // return view('shop-right-sidebar', ['books' => book::all()]);
        
         }
         else{
            // request()->session()->flash('error','Invalid email and password pleas try again!');
            // return redirect()->back();
            echo "error";
        }
       
    }


    public function customUpdate(Request $request){

        $user = Auth::user();
        $userPassword =$user->password;

        $request->validate([
            'first_name' =>'required|min:4|string|max:255',
            'last_name' =>'required|min:4|string|max:255',
            'password'=> 'required',
            'newpassword'=> 'required|same:confirmpassword|min:6',
            'confirmpassword'=> 'required',
            'email'=>'required|email|string|max:255'
        ]);
        $user =Auth::user();
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->email = $request['email'];
        $user->save();

        if (!Hash::check($request->password , $userPassword ))
        {   echo "wrong password";
            //session()->flash('message','old password doesnt matched ');
            //return redirect()->back();
        }

        $user->password = Hash::make ($request->newpassword);

        $user->save();
        session()->flash('message','password updated successfully');
        return redirect()->back();
       
     }
}