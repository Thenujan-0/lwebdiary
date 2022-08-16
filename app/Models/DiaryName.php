<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaryName extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $fillable = ["diary_name","user_id"];

}
