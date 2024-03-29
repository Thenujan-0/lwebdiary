<link rel="stylesheet" href="{{asset('css/createDiary.css')}}">
@env("local")
    <script src="{{asset('js/createDiary.js')}}"></script>
@endenv

@env("heroku")
    <script src="{{secure_asset('js/createDiary.js')}}"></script>
@endenv
<form action="createDiary" method="post" id="formCreateDiary" enctype="multipart/form-data" style="display:none">
    @csrf
    <label>Enter the name of new diary</label>
    <input type="text" name="diary_name">
    <div class="error animDance" style="visibility:hidden;">
            <p class="errorMsg"></p>
        </div>
    <div class="btnGroup">
        <input type="button" class="btn btnCancel btnSecondary" value="Cancel">
        
        <input type="submit" class="btn btnPrimary" value="Create">
    </div>
</form>