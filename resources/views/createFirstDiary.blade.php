
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @env("local")
        <link rel="stylesheet" href="{{asset("css/createFirstDiary.css")}}">
        <script src="{{asset('js/createFirstDiary.js')}}"></script>
    @endenv
    @env("heroku")
        <link rel="stylesheet" href="{{secure_asset("css/createFirstDiary.css")}}">
        <script src="{{secure_asset('js/createFirstDiary.js')}}"></script>
    @endenv
    <title>Welcome</title>
</head>
<body>
    <div id="createFirstDiary">
        <form method="post" id="createDiaryForm" action="createDiary" enctype="multipart/form-data">
            @csrf
            <h2>Welcome to web diary</h2>
            <h2>To get started create your first diary</h2>
            <div class="name">
                <p>Diary name</p>
                <input type="text" name="diary_name">
            </div>
            @error("diary_name")<span class="errorText">{{$message}}</span>@enderror
            <p>You can create more than one diaries and keep different stories
                seperated 
            </p>
            <button>Create</button>
        </form>
    </div>
</body>
</html>