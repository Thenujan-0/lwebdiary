@extends('layouts.app')
    @section('head')
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <link rel="stylesheet" href="{{asset('css/smallIndex.css')}}">

    <script>
        var token ="{{ csrf_token() }}";
    </script>
    {{-- <script src="{{asset('js/index.js')}}"></script> --}}
    <title>Tera Diary</title>
    @endsection
    
@section("content")
    <button class="btn btnWrite">Write</button>

    <div class="main">
        <div id="topBar">
            <div class="buttons">
                <button class="btn" id="btnExport">Export</button>
                <button class="btn" id="btnImport">Import</button>
                <input type="file" name="importFile" id="importFileInput" accept=".json" hidden>
            </div>
            <h1>{{$firstName}}'s personal diary</h1>
            <div></div>
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
                <select>
                    @foreach($diaryNames as $key=>$diaryName)
                        @if($key==0)
                            <option selected>{{$diaryName}}</option>
                        @else
                            <option>{{$diaryName}}</option>
                        @endif
                    @endforeach
                </select>

                
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
    <div id="darkOverlay" style="display:none;"></div>
    @include("includes.writeDiary")
    @include("includes.createDiary")
    @error('newerror') 
    <h1>{{$message}}</h1>
    @enderror
@endsection