<?php

namespace App\Http\Controllers;

use App\Models\DiaryEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Debugbar;
use Illuminate\Support\Facades\Http;

class DiaryEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {
        return $request->date;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id=Session::get("user_id");
        $date=$request->input("date");
        $data=$request->input("data");
        $diaries=$request->input("selectedDiaries");


        DiaryEntry::insert(["user_id"=>$user_id,"date"=>$date,"data"=>$data]);   
        return response("true");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $date = $request->date;
        $user_id=Session::get("user_id");
        $data = DiaryEntry::where(["user_id"=>$user_id,"date"=>$date])->first("data")->data;
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Debugbar::warning("request recieved");
        $date=$request->date;
        $user_id= Session::get("user_id");

        DiaryEntry::where(["user_id"=>$user_id,"date"=>$date])->delete();
        return response([],200);

    }
}
