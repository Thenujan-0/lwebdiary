@extends('layouts.app')
    @section('head')
    <link rel="stylesheet" href="{{secure_secure_asset('css/index.css')}}">
    <script>
        var token ="{{ csrf_token() }}";
    </script>
    <script src="{{secure_secure_asset('js/index.js')}}"></script>
    <title>Web Diary</title>
    @endsection
    
@section("content")
    <button class="btn btnWrite">Write</button>

    <div class="main">
        <div id="topBar">
            <h1>{{$firstName}}'s personal diary</h1>
            <!-- <button id="btnWriteEntry">Write a new entry</button> -->
        </div>

        <div id="sideBar">
            <input type="date" id="selectedDate" hidden>
        <ul>
                
                @foreach($dates as $index=>$date)
                    @if ($index==0)
                        <li><button class="btn btnDate selected">{{$date}}</button></li>
                    @else
                        <li><button class="btn btnDate">{{$date}}</button></li>
                    @endif
                @endforeach
        </ul>
        </div>
        <div id="diaryContent">
            <div class="diaryNames">
                @foreach($diaryNames as $key=>$diaryName)

                    @if($key==0)
                        <button class="btnDiary selected">{{$diaryName}}</button>
                    @else
                        <button class="btnDiary">{{$diaryName}}</button>
                    @endif
                    
                @endforeach
                <button class="btn btnCreateDiary">Create a diary</button>
                
            </div>
            <div class="diaryDataWrapper">
                <p class="diaryData"></p>
                <div class="buttons">
                    <button class="btn btnEdit">Edit</button>
                    <button class="btn btnDel">Delete</button>
                </div>

            </div>
        </div>
        
    </div>
    <div id="darkOverlay" style="display:none;"></div>
    @include("writeDiary")
    @include("createDiary")
    
@endsection
{{-- </body> --}}
{{-- </html> --}}