<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Debugbar;





class DiaryController extends Controller

{
    
    public function writeDiary(Request $request){
        return redirect()->route("diaryEntry.create",$request);
    }
}
