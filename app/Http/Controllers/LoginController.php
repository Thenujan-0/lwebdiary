<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Session;
use Illuminate\Support\Facades\Session;
use App\Models\Users_table;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Debugbar;
class LoginController extends Controller
{

    public function loginUser(Request $request){

        //Validate the email first
        $request->validate([
            'email'=>'required|max:255|email',
            
        ]);
        //And then save the email in cookie
        $email=$request->input("email");
        $THIRTY_DAYS_IN_MINS =60*24*30;
        cookie("email",$email,$THIRTY_DAYS_IN_MINS);
        $request->validate([
            'password'=>'required'
        ]);

        $email = $request->input("email");
        $password_sum = hash("sha256",$request->input("password"));
        $data= User::get()->where("email",$email)->first();

        if (empty($data)){
            DebugBar::warning("No account with email");
            return back()->withErrors(['main'=>'There is no account on this email address']);
        }
        
        if ($data->password!=$password_sum){
            return back()->withErrors(['main'=>'Invalid password']);
        }
        // dd($data->id);
        $user_id =$data->id;
        Session::put("user_id",$user_id);
        debugBar::warning($user_id);    
        debugBar::warning("user_id".Session::get($user_id));
        Session::put("name",$data->value("name"));
        Cookie::queue("user_id",$user_id,5);
        return redirect()->route("index");

    }

    public function registerUser(Request $request){
        $request->validate([
            'fullname'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required'
        ],["email.unique"=>"This email is already registered"]);
        $name=$request->input("fullname");
        $email=$request->input("email");
        $password=hash('sha256',$request->input("password"));
        try{
            User::insert([
                'name'=>$name,
                'email'=>$email,
                'password'=>$password
            ]);

            //Add session variables
            $user_id=User::get()->where("email",$email)->first()->value("id");
            Session::put(["user_id"=>$user_id,"name"=>$name]);

            return redirect()->route("index");

        }catch(Exception $e){
            return back()->withErrors(['main'=>'Couldn\'t create account. An error occured']);
        }
    }

    public function logoutUser(Request $request){
        $request->session()->flush();
        return redirect("login");
    }


    public function login(){
        $email=Cookie::get("email");

        return view("auth.login",["email"=>$email]);
    }

    public function signup(){
        return view("auth.signup");
    }

    public static function validUserId() : bool
    {
        $user_id = Session::get("user_id");
        $user = User::find($user_id);
        if (is_null($user)){
            return false;
        }
        return true;
    }
    
    
}
