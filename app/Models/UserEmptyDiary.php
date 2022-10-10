<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;


use App\Models\DiaryName;


class UserEmptyDiary extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $fillable=["user_id","diary_name_id"];

    public function diaryName(){
        return $this->belongsTo(DiaryName::class,"_id.toString()","diary_name_id.toString()");
    }

}
