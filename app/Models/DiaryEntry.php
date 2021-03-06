<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DiaryName;


class DiaryEntry extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table="diary_entries";

    protected $hidden=["user_id"];

    public function diaryName(){
        return $this->belongsTo(DiaryName::class);
    }
}