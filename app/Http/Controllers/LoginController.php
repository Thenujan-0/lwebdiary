<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Session;
use Illuminate\Support\Facades\Session;
use App\Models\Users_table;
use App\Models\User;
use Exception;

class LoginController extends Controller
{
    // public function loginUser(Request $request){
    //     // dd($request->all());
    //     $name = $request->input("email");
    //     $password_sum = hash("sha256",$request->input("password"));
        
    //     // $data =DB::table("users")->where("email",$name)->where("password_sha256",$password)->first();
    //     $data= Users_table::get()->where("email",$name)->where("password_sha256",$password_sum)->first();
    //     if (empty($data)){
    //         return redirect()->route("login")->with("error","Invalid email or password");
    //     }else{
    //         Session::put("user_id",$data->value("user_id"));
    //         Session::put("username",$data->value("username"));

    //         // return $arr["user_id"];
    //         return redirect()->route('index');
    //     // return redirect()->route("index");
    //     }
    // }

    public function loginUser(Request $request){
        $request->validate([
            'email'=>'required|max:255|email',
            'password'=>'required'
        ]);

        $name = $request->input("email");
        $password_sum = hash("sha256",$request->input("password"));
        $data= User::get()->where("email",$name)->where("password",$password_sum)->first();

        if (!empty($data)){
            Session::put("user_id",$data->value("id"));
            Session::put("name",$data->value("name"));
            return redirect()->route("index");
        }else{

            return back()->withErrors(['main'=>'Invalid email or password '.$data]);

        }

    }

    public function registerUser(Request $request){
        $request->validate([
            'fullname'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required'
        ]);
        $name=$request->input("fullname");
        $email=$request->input("email");
        $password=hash('sha256',$request->input("password"));
        try{
            User::insert([
                'name'=>$name,
                'email'=>$email,
                'password'=>$password
            ]);
            return redirect()->route("index");;

        }catch(Exception $e){
            return back()->withErrors(['main'=>'Couldn\'t create account. An error occured']);

        }

    }

    public function login(){
        return view("auth.login");
    }

    public function signup(){
        return view("auth.signup");
    }
    
    
}
