@extends('layouts.app')
    @section('head')
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <script>
        var token ="{{ csrf_token() }}";
    </script>
    <script src="{{asset('js/index.js')}}"></script>
    <script defer src="{{asset('js/simple.js')}}"></script>
    <title>Tera Diary</title>
    @endsection

@section("content")
    <button class="btn btnWrite">Write</button>

    <div class="main">
        <div id="topBar">
            {{-- <div class="buttons">
                <button class="btn" id="btnExport">Export</button>
                <button class="btn" id="btnImport">Import</button>
                <input type="file" name="importFile" id="importFileInput" accept=".json" hidden>
            </div> --}}
            <h1 id="brand-logo">Tera Diary</h1>
            <div></div>
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
                    <select class="diaryNames">
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
                                    <button class="btnDiary selected">{{$diaryName}}</button>
                                @else
                                    <button class="btnDiary">{{$diaryName}}</button>
                                @endif
                            @endforeach
                        <i class="fa-solid fa-angle-right btnNext"></i>
                    </div>
                    <button class="btn btnCreateDiary">Create a diary</button>
                    {{-- </div> --}}
                </div>
                <div class="diaryDataHeader">
                    <p>{{$diaryNames[0]}}</p>
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