@extends('layouts.app')
    @section('head')
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <script>
        var token ="{{ csrf_token() }}";
    </script>
    @env('local')
    <script src="{{asset('js/index.js')}}"></script>
    <script defer src="{{asset('js/simple.js')}}"></script>
    @endenv
    
    @production
    <script src="{{secure_asset('js/index.js')}}"></script>
    <script defer src="{{secure_asset('js/simple.js')}}"></script>
    @endproduction

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
                        @foreach($diaryNames as $key=>$diaryName)
                            @if ($key==0)
                                <option value="{{$diaryName}}" selected>{{$diaryName}}</option>
                            @else
                                <option value="{{$diaryName}}">{{$diaryName}}</option>
                            @endif
                        @endforeach
                    </select>

                    <div class="diaryNames">
                        <i class="fa-solid fa-angle-left btnBefore"></i>
                            @foreach($diaryNames as $key=>$diaryName)
                                @if($key==0)
                                    <button class="btn btnDiary selected">{{$diaryName}}</button>
                                @else
                                    <button class="btn btnDiary">{{$diaryName}}</button>
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
                    <p id="diaryName">{{$diaryNames[0]}}</p>
                    <p class="selectedDate">{{$dates[0]}}</p>
                    {{-- <p>{{$selectedDate}}</p> --}}
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
                        <button class="btn btnEdit">Edit</button>
                        <button class="btn btnDel">Delete</button>
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