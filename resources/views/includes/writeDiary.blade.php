    
<link rel="stylesheet" href="{{asset("css/writeDiary.css")}}">

<script src="{{asset("js/writeDiary.js")}}"></script>
<form action="diaryEntry/create" id="formWriteDiary" enctype="multipart/form-data" method="put" style="display:none;">
    @csrf
    {{-- <input type="button" id="btnBackWriteDiary" value='Back'> --}}
    <div class="inputGroup date">
        <label>Select date you want to add the entry to</label>
        <input type="date" id="date" name="date">
        <div class="error animDance" style="visibility:hidden;">
            <p class="errorMsg">Date already exists in diary</p>
        </div>
    </div>

    <div class="inputGroup selectedDiaries" >
        <label>Select diaries to add this entry to</label>
        <select name="diaryName" id="">
            @foreach($diaryNames as $diary)
                    <option value="{{$diary}}">{{$diary}}</option>
            @endforeach
        </select>
        {{-- <ul>

        
            @foreach($diaryNames as $diary)
                <li><div class='btn btnDiary'>
                        <p>{{$diary}}</p>
                    </div>
                </li>
            @endforeach
            

        </ul> --}}
        <div class="error animDance" style="visibility:hidden;">
            <p class="errorMsg"></p>
        </div>
        <input type="text" id="selectedDiaries" name="selectedDiaries" hidden>
    </div>
    
    <div class="inputGroup diaryText">
        <label>Write your diary</label>
        <textarea name="data" id="diaryText" placeholder="Write all the interesting things that happened on this day"></textarea>
        <div class="error animDance" style="visibility:hidden;">
            <p class="errorMsg"></p>
        </div>
    </div>
    <div class="buttons">
        <input type="button" name="back" class="btn btnBack btnSecondary" id="btnBackWriteDiary" value='Back'>

        <input type="submit" name="submit" class="btn btnAdd" value="Add">
    </div>
</form>