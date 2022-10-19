@extends('layouts.app')
    @section('head')
    
    <script>
        var token ="{{ csrf_token() }}";
    </script>
    
    {{-- @env("heroku")
        <script src="{{secure_asset('js/index.js')}}"></script>
        <link rel="stylesheet" href="{{secure_asset('css/index.css')}}">
    @endenv
    @env("local")
        <script src="{{asset('js/index.js')}}"></script>
        <link rel="stylesheet" href="{{asset('css/index.css')}}">
    @endenv --}}

    @vite(["resources/js/diaryNamesBar.js","resources/assets/sass/index.scss","resources/js/index.js"])

    <title>Tera Diary</title>
    @endsection

@section("content")
    <button class="btn btnWrite">Write</button>

    <div class="main">
        <div id="topBar">

            <h1 id="brand-logo">Tera Diary</h1>
            <div class="buttons">
                <button class="btn" id="btnImport">Import</button>
                <button class="btn" id="btnExport">Export</button>
                <input type="file" name="importFile" id="importFileInput" accept=".json" hidden>
            </div>
        </div>
        <div id="appBody">
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
                <div id="diaryNamesBar">
                    {{-- <div class="diaryNames"> --}}
                    <select class="diaryNames select">
                        @foreach($diaryNames as $key=>$diaryNameObj)
                            @if ($key==0)
                                <option value="{{$diaryNameObj["diary_name"]}}" selected>{{$diaryNameObj["diary_name"]}}</option>
                            @else
                                <option value="{{$diaryNameObj["diary_name"]}}">{{$diaryNameObj["diary_name"]}}</option>
                            @endif
                        @endforeach
                    </select>

                    <div class="diaryNames">
                        <i class="fa-solid fa-angle-left btnBefore"></i>
                            @foreach($diaryNames as $key=>$diaryNameObj)
                                @if($key==0)
                                    <button class="btn btnDiary selected" data-id="{{$diaryNameObj["_id"]}}">{{$diaryNameObj["diary_name"]}}</button>
                                @else
                                    <button class="btn btnDiary" data-id="{{$diaryNameObj["_id"]}}">{{$diaryNameObj["diary_name"]}}</button>
                                @endif
                            @endforeach
                        <i class="fa-solid fa-angle-right btnNext"></i>
                    </div>
                    <button class="btn btnCreateDiary">Create a diary</button>

                    <select class="dates select" id="selectedDateInput">
                        @foreach($dates as $key=>$date)
                            @if ($key==0)
                                <option value="{{$date}}" selected>{{$date}}</option>
                            @else
                                <option value="{{$date}}">{{$date}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="diaryDataHeader">
                    @if(!empty($diaryNames))
                    <p id="diaryName">{{$diaryNames[0]["diary_name"]}}</p>
                    @endif

                    @if(!empty($dates))
                        
                    <p class="selectedDate">{{$dates[0]}}</p>
                    @endif
                </div>
                <div class="diaryDataWrapper">
                    <p class="diaryData"></p>
                    <div class="diaryDataSkeletons">
                        <div class="diaryDataSkeleton"></div>
                        <div class="diaryDataSkeleton"></div>
                        <div class="diaryDataSkeleton"></div>
                        <div class="diaryDataSkeleton"></div>
                        <div class="diaryDataSkeleton"></div>

                        
                    </div>
                    <div class="buttons">
                        <button class="btn btnEdit"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn btnDel"><i class="fa-solid fa-trash"></i></button>
                    </div>

                </div>
            </div>
        </div>
        
    </div>
    <div id="darkOverlay" style="display:none;"></div>
    @include("includes.writeDiary")
    @include("includes.createDiary")
    @error('newerror') 
    <h1>{{$message}}</h1>
    @enderror
@endsection