@extends("layouts.app")

@section("head")
<<<<<<< HEAD
    @env("local")
        <link rel="stylesheet" href="{{asset("css/signup-login.css")}}">

    @endenv

    @production
        <link rel="stylesheet" href="{{secure_asset("css/signup-login.css")}}">

    @endproduction
=======
    <link rel="stylesheet" href="{{secure_asset("css/signup-login.css")}}">
>>>>>>> 15c3a9b2d6b9324ecae163459bd2eeb2c5fa4d73
    <script src="js/signup.js"></script>
    <title>Signup WebDiary</title>
@endsection

@section("content")
    <div class="cont">
        <div class="main">
<<<<<<< HEAD
            @env("local")
                <img src="{{asset('images/brand_name.svg')}}" >

            @endenv

            @production
                <img src="{{secure_asset('images/brand_name.svg')}}" >

            @endproduction
=======
            <img src="{{secure_asset('images/brand_name.svg')}}" >
>>>>>>> 15c3a9b2d6b9324ecae163459bd2eeb2c5fa4d73
            <form id="signupForm" method="POST" action="{{route('registerUser')}}" enctype="multipart/form-data">
                <fieldset>
                @csrf   
                <h1>Signup</h1>
                <span class="errorText" >@error('main') {{$message}} @enderror</span>
                <br/>
                <br/>

                <div class="formGroup">
                    <label for="fullname">Full Name</label>
                    <input type="text" name="fullname">
                    <span class="errorText" >@error('fullname') {{$message}} @enderror</span>
                </div>

                <div class="formGroup">
                    <label for="email">Email</label>
                    <input type="email" name="email">
                    <span class="errorText" >@error('email') {{$message}} @enderror</span>
                </div>

                <div class="formGroup">
                    <label for="password">Password</label>
                    <input type="password" name="password">
                    <span class="errorText" >@error('password') {{$message}} @enderror</span>
                </div>

                <input type="submit" class="btn" value="Signup" name="submit">
                <!-- <button id="signupButton" action="submit">Signup </button> -->

                <p>Already have an account? <a href="{{route('login')}}" class="anchor">Login</a></p>
                </fieldset>
            </form>
        </div>
    </div>
@endsection