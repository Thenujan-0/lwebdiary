<link rel="stylesheet" href="{{asset('css/createDiary.css')}}">
<script src="{{asset('js/createDiary.js')}}"></script>
<form action="createDiary" method="post" id="formCreateDiary" enctype="multipart/form-data" style="display:none">
    
    <label>Enter the name of new diary</label>
    <input type="text" name="diaryName">
    <div class="error animDance" style="visibility:hidden;">
            <p class="errorMsg"></p>
        </div>
    <div class="btnGroup">
        <input type="button" class="btn btnCancel" value="Cancel">
        
        <input type="submit" class="btn" value="Create">
    </div>
</form>