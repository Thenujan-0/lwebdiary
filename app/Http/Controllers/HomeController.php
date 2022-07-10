<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DiaryName;
use App\Models\UserEmptyDiary;
use App\Models\DiaryEntry;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index(){


        
        //Check if logged in
        if( !(session()->has("user_id") && session()->has("name")) ){
            $email=Cookie::get("email");
            return view("auth.login",compact("email"));

        }
        
        //Check if a diary exists
        $user_id=Session::get("user_id");
        $emptyDiaries=UserEmptyDiary::where("user_id",$user_id)->get()->count();
        $nonEmptyDiaries=DiaryEntry::where("user_id",$user_id)->distinct("diary_name_id")->get()->count();
        // dd($emptyDiaries,$nonEmptyDiaries);
        $hasDiary = $nonEmptyDiaries + $emptyDiaries> 0;

        
        if (!$hasDiary){
            return view("createFirstDiary");
        }
        

        $dates=DiaryEntry::where("user_id",$user_id)->get()->pluck("date")->unique()->toArray();
        // dd($dates);
        $emptyDiaryNameIds=UserEmptyDiary::where("user_id",$user_id)->get()->pluck("diary_name_id");
        // dd(($diaryNameIds));

        //Check if there is only one or more and do the operations suitable for that to get the emptyDiarynames
        if(count($emptyDiaryNameIds)>1){
            $diaryNames=DB::table("diary_names")->whereIn("id",$emptyDiaryNameIds)->get()->pluck("diary_name")->toArray();
        }else{
            // dd($diaryNameIds[0]);
            $diaryNames=Array();
            $name=DB::table("diary_names")->where("id",$emptyDiaryNameIds[0])->first("diary_name")->diary_name;
            // dd($name);
            array_push($diaryNames,$name);
        }

        //Todo get the nonempty diaries

        // dd($diaryNames);
        $firstName=explode(" ",DB::table("users")->where("id",$user_id)->first("name")->name)[0];
        // dd($firstName);
        // dd($dates);
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
}
