<?php

namespace App\Http\Controllers;

use App\Models\DiaryEntry;
use App\Models\DiaryName;
use App\Models\UserEmptyDiary;
use Illuminate\Http\Request;
use Debugbar;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

        $emptyDiaryList=UserEmptyDiary::where("user_id",$user_id)->distinct()->get("diary_name_id");

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

    public static function getDiaryNames($user_id){
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

        $nonEmptyDiaries=DiaryEntry::where("user_id",$user_id)->distinct("diary_name_id")->get();
        foreach($nonEmptyDiaries as $diary){
            $diaryName=$diary->diaryName();
            if (!in_array($diaryName,$diaryNames)){
                debugBar::warning($diaryName);
                array_push($diaryNames,$diaryName);

            }
        }
        return $diaryNames;
    }

    public function getEmptyDiaryNames(Request $request){
        try{
            $user_id=Session::get("user_id");
            $date=$request->date;
            $out =DiaryEntry::where(["user_id"=>$user_id,"date"=>$date])->distinct()->get("diary_name_id");

            $nonEmptyDiaries=[];
            foreach($out as $o){
                array_push($nonEmptyDiaries,$o->diaryName());
            }
            $out = json_encode($nonEmptyDiaries);

            $allDiaries= DiaryController::getDiaryNames($user_id);

            foreach($nonEmptyDiaries as $nonEmptyDiary){
                $key=array_search($nonEmptyDiary,$allDiaries);
                unset($allDiaries[$key]);
            }

            $emptyDiaries=json_encode(array_values($allDiaries));
            Debugbar::warning($emptyDiaries);

            return response($emptyDiaries);
        }catch (Exception $e){
            Log::info("An error occured in get non empty diaries");
            Log::info($e->getMessage());
            echo $e->getMessage();
            return response($e->getMessage(),200);
        }
    }

    public function importDiary(Request $request){
        $user_id=Session::get("user_id");
        $fileData=$request->get("fileData");
        Debugbar::warning($fileData);
        $json =json_decode($fileData,true);
        Debugbar::warning($json);

        foreach($json as $jsonObj){
            $date=$jsonObj["date"];
            $diaryName=$jsonObj["diary_name"];

            $diaryNameRecord =DiaryName::where("diary_name",$diaryName)->first();
            if ($diaryNameRecord == null){
                $diaryName = DiaryName::firstOrCreate(["diary_name"=>$diaryName]);
                $diaryName->save();
                $diaryId=$diaryName->id;
            }else{
                $diaryId=$diaryNameRecord->id;

            }
            $data=$jsonObj["data"];
            Debugbar::warning($data);
            $diaryEntry=DiaryEntry::firstOrCreate(["user_id"=>$user_id,"date"=>$date,"diary_name_id"=>$diaryId,"data"=>$data]);
            
            $diaryEntry->save();
        }

        return response("true",200);
    }
}
