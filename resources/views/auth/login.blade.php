<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{secure_secure_asset("css/signup-login.css")}}">
    {{-- <script src="js/login.js"></script> --}}
    <title>Login WebDiary</title>
</head>
<body>
    
    <form id="loginForm" method="POST" enctype="multipart-form-data" action="loginUser">
        @csrf
    <fieldset>
        @error('main')
        <div class="error animDance" >
            {{$message}}
        </div>
        @enderror
        <h1>Login</h1>


        <div class="formGroup">
            <p>Email</p>
            <input type="email" name="email" id="email" value="<?php if(isset($_COOKIE["email"])){echo $_COOKIE["email"];}else{echo "";}?>">
        </div>

        <div class="formGroup">
            <p>Password</p>
            <input type="password" id="password" name="password">
        </div>
        <input type="submit" class="btn" value="Login" name="submit">
        <p>Don't have an account? <a href="{{route('signup')}}" class="anchor">Signup</a></p>
    </fieldset>
    </form>
    
</body>
</html>