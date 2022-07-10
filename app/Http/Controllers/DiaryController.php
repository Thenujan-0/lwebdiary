<?php

namespace App\Http\Controllers;

use App\Models\DiaryEntry;
use App\Models\DiaryName;
use App\Models\UserEmptyDiary;
use Illuminate\Http\Request;
use Debugbar;
use Illuminate\Support\Facades\Session;

class DiaryController extends Controller
{
    public function writeDiary(Request $request){
        $user_id=Session::get("user_id");
        $allowDuplicateDates=$request->input("allowDuplicateDates");

        $request->validate([
            'date' => 'required|date',
            'data' => 'required|string',
        ]);

        if(!$allowDuplicateDates){
            $request->validate(['date'=>'unique:diary_entries,date,0,id,user_id,'.$user_id]);
        }
        return redirect()->route("diaryEntry.create",$request);
    }

    public function createDiary(Request $request){
        
        $request->validate(["diary_name"=>"required"]);
        
        $user_id=Session::get("user_id");
        
        $dName=$request->input("diary_name");
        
        $diaryName = DiaryName::firstOrCreate(["diary_name"=>$dName]);
        $id= $diaryName->id;

        
        //Check if this diary already exists in user's diary list
        $diaryList=DiaryEntry::where("user_id",$user_id)->distinct("diary_name_id")->get();

        
        $diaryNames=Array();
        foreach($diaryList as $diary){
            array_push($diaryNames,$diary->diaryName->diary_name);
        }

        $emptyDiaryList=UserEmptyDiary::where("user_id",$user_id)->distinct("diary_name_id")->get();

        foreach($emptyDiaryList as $diary){
            array_push($diaryNames,$diary->diaryName->diary_name);
        }

        if(!in_array($id,$diaryNames)){
            UserEmptyDiary::firstOrCreate(["user_id"=>$user_id,"diary_name_id"=>$id]);

        }
        
        //Check if the created diary is his first diary
        $check = $diaryList->count()==0 && $emptyDiaryList->count()==0;
        if ($check){
            return redirect()->route("index");
        }
        return response($id,200);




    }

    public function exportDiary(Request $request){
        // return response("couldn't export",200);
        $user_id=Session::get("user_id");
        $diaryEntriesColl=DiaryEntry::where("user_id",$user_id)->get();
        // dd($diaryEntries);
        // echo($diaryEntries);
        $diaryEntries=$diaryEntriesColl->toArray();
        foreach($diaryEntriesColl as $key=>$diaryEntry){

            //Remove diary_name_id
            unset($diaryEntries[$key]["diary_name_id"]);
            unset($diaryEntries[$key]["id"]);

            //Set diary name for each diary entry
            $diaryEntries[$key]["diary_name"]=$diaryEntry->diaryName->diary_name;
        }

        return response(json_encode($diaryEntries),200);
    }

    public function dateExists(Request $request){
        $user_id=Session::get("user_id");
        $date=$request->date;
        $diaryEntriesCount=DiaryEntry::where("user_id",$user_id)->where("date",$date)->count();
        if($diaryEntriesCount>0){
            return response("true",200);
        }
        else{
            return response("false",200);
        }
    }

    public function editDiaryData(Request $request){
        $user_id=Session::get("user_id");
        $date=$request->date;
        $data=$request->data;
        $selectedDiary=$request->selectedDiary;
        $diaryId=DiaryName::where("diary_name",$selectedDiary)->first()->id;

        DiaryEntry::where(["user_id"=>$user_id,"date"=>$date,"diary_name_id"=>$diaryId])->update(["data"=>$data]);
        return response("true",200);
    }
}
