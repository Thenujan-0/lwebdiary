
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{URL::asset("css/createFirstDiary.css")}}">
    <script src="js/createFirstDiary.js"></script>
    <title>Welcome</title>
</head>
<body>
    <div id="createFirstDiary">
        <form method="post" id="createDiaryForm" action="createFirstDiary" enctype="multipart/form-data">
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