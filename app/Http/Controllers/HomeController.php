<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DiaryName;
use App\Models\UserEmptyDiary;
use App\Models\DiaryEntry;
use Debugbar;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LoginController;

class HomeController extends Controller
{
    public function index(){
        // Session::flush();

        //First check if screen size is set in cookie if not send js that sets screensize cookie and then reloads
        // DebugBar::warning("HomeController::index()",Cookie::has("screenSize"),Cookie::get("screenSize"));
        // if(!Cookie::has("screenSize")){
        //     DebugBar::warning("cookie not found",Cookie::has("screenSize"));

        //     return view('includes.setScreenSize');
        // }
        // $screenSize=Cookie::get("screenSize");
        // Cookie::queue(Cookie::forget("screenSize"));
        // echo Cookie::get("screenSize");
        // echo "\n";
        // echo Cookie::has("screenSize");
        // echo $screenSize;


        
        //Check if logged in
        $notLoggedIn =!(session()->has("user_id"));
        
        if($notLoggedIn || !LoginController::validUserId()){
            // return view("auth.login",compact("email"));
            return redirect("login");

        }
        
        //Check if a diary exists
        $user_id=Session::get("user_id");
        $emptyDiaries=UserEmptyDiary::where("user_id",$user_id)->get()->count();
        $nonEmptyDiaries=DiaryEntry::where("user_id",$user_id)->distinct("diary_name_id")->get()->count();
        // dd($emptyDiaries,$nonEmptyDiaries);
        $hasDiary = $nonEmptyDiaries + $emptyDiaries> 0;

        
        if (!$hasDiary){
            return view("createFirstDiary",["userId"=>$user_id]);
        }
        
        // dd($data1);

        $dates=DiaryEntry::where("user_id",$user_id)->orderBy("date","DESC")->pluck("date")->unique()->toArray();
        // dd($dates);
        $diaryNames=DiaryController::getDiaryNames($user_id);

        $firstName=explode(" ",User::find($user_id)->first()->name)[0];

        // if ($screenSize<=500){
        //     return view("smallScreen.index",compact("diaryNames","dates","firstName"));
        // }

        return view("index",compact("dates","firstName","diaryNames"));
        
    }

    public function createFirstDiary(Request $request){

        // $request->validate([
        //     'diary_name'=>"required"
        // ]);

        // $diaryName=$request->input("diary_name");
        // // dd($diaryName);

        // $user_id=Session::get("user_id");


        // //Check if this diary name already exists
        // $count = DB::table("diary_names")->where("diary_name",$diaryName)->count();

        // //If this diaryName does not exist then create it
        // if(! ($count>0)){
        //     DiaryName::create(["diary_name"=>$diaryName]);
        //     $diaryNameId = DB::table("diary_names")->where("diary_name",$diaryName)->first("id")->id;
        //     // dd($diaryNameId);
        //     UserEmptyDiary::create(["user_id"=>$user_id,"diary_name_id"=>$diaryNameId]);
        // }


        // //Now check if user has this diary

        // return back()->withErrors(["diary_name"=>"A diary already exists in this name"]);


        // return redirect()->route("index");

    }

    public function setScreenSize(Request $request){
        DebugBar::warning("yes recv");
        $request->validate([]);
        $screenSize = $request->input("screenSize");
        // Cookie::queue("screenSize",$screenSize,60*24*30);
    }
}
