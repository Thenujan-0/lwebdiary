<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\DiaryName;
use App\Models\DiaryEntry;
use Debugbar;
use Exception;

class User extends Model
{
    use HasFactory;
    public $timestamps=false;

    public function diaryNames(){
        $user_id = $this->id;
        // try{

            $emptyDiaryNameIds=UserEmptyDiary::where("user_id",$user_id)->get()->pluck("diary_name_id");
            // dd((UserEmptyDiary::where("user_id",$user_id)->first()->diaryName()->diaryName));

            //Check if there is only one or more and do the operations suitable for that to get the emptyDiarynames
            if(count($emptyDiaryNameIds)>1){
                $diaryNames=DiaryName::whereIn("_id",$emptyDiaryNameIds)->get()->pluck("diary_name")->toArray();
            }else{
                // dd($diaryNameIds[0]);
                $diaryNames=Array();
                // dd($emptyDiaryNameIds);
                $name=DiaryName::find($emptyDiaryNameIds[0])->first()->diary_name;
                // dd($name);
                array_push($diaryNames,$name);
            }
            // dd($diaryNames);

            $nonEmptyDiaries=DiaryEntry::where("user_id",$user_id)->groupBy("diary_name_id")->get();
            // dd($nonEmptyDiaries);
            foreach($nonEmptyDiaries as $diary){
                // dd($diary->diaryName()->first()->diary_name);
                // if($diary->diaryName()->count()==0){
                //     break;
                // }
                $diaryNameId=$diary->diary_name_id;
                // dd($diary);
                // $diaryName= DiaryName::find($diaryNameId)->diary_name;
                $diaryName = $diary->diaryName()->first()->diary_name;
                // dd($diaryName);
                if (!in_array($diaryName,$diaryNames)){
                    // debugBar::warning($diaryName);
                    array_push($diaryNames,$diaryName);

                }
            }
            debugBar::warning($diaryNames);
            return $diaryNames;
        // }catch(Exception $e){
        //     dd($e->getMessage()." in user.php");
        //     debugBar::warning("An error uselesss ");
        // }
    }
}
