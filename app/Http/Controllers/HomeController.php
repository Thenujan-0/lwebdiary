<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DiaryName;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index(){


        
        //Check if logged in
        if( !(session()->has("user_id") && session()->has("name")) ){
            return view("auth.login");

        //Check if a diary exists
        }
        
        $user_id=Session::get("user_id");

        $hasDiary = DB::table("user_diaries")->where("user_id",$user_id)->count() > 0;
        // dd($hasDiary);

        
        if (!$hasDiary){
            return view("createFirstDiary");
        }
        
        else{

            $dates=DB::table("diary_entries")->where("user_id",$user_id)->get()->pluck("date");
            // dd($dates);
            $diaryNameIds=DB::table("user_diaries")->where("user_id",$user_id)->get()->pluck("diary_name_id");
            // dd(($diaryNameIds));
            if(count($diaryNameIds)>1){
                $diaryNames=DB::table("diary_names")->whereBetween("id",$diaryNameIds)->get()->pluck("diary_name")->items;
            }else{
                // dd($diaryNameIds[0]);
                $diaryNames=Array();
                $name=DB::table("diary_names")->where("id",$diaryNameIds[0])->first("diary_name")->diary_name;
                // dd($name);
                array_push($diaryNames,$name);
            }
            // dd($diaryNames);
            $firstName=explode(" ",DB::table("users")->where("id",$user_id)->first("name")->name)[0];
            // dd($firstName);
            return view("index",compact("dates","firstName","diaryNames"));
        }
        
    }

    public function createFirstDiary(Request $request){

        $request->validate([
            'diary_name'=>"required"
        ]);

        $diaryName=$request->input("diary_name");
        // dd($diaryName);

        $user_id=Session::get("user_id");


        //Check if this diary name already exists
        $count = DB::table("diary_names")->where("diary_name",$diaryName)->count();

        //If this diaryName does not exist then create it
        if(! ($count>0)){
            DB::table("diary_names")->insert(["diary_name"=>$diaryName]);
            $diaryNameId = DB::table("diary_names")->where("diary_name",$diaryName)->first("id")->id;
            // dd($diaryNameId);
            DB::table("user_diaries")->insert(["user_id"=>$user_id,"diary_name_id"=>$diaryNameId]);
        }


        //Now check if user has this diary

        return back()->withErrors(["diary_name"=>"A diary already exists in this name"]);


        return redirect()->route("index");

    }
}
