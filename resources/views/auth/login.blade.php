@extends("layouts.app")
    
@section("head")
    @vite(["resources/assets/sass/signup-login.scss"])
    <title>Login WebDiary</title>
@endsection

@section("content")

    <div class="cont">
        <div class="main">
            @env("local")
                <img src="{{asset('images/brand_name.svg')}}" >

            @endenv

            @env("heroku")
                <img src="{{secure_asset('images/brand_name.svg')}}" >
            @endenv

            <form id="loginForm" method="POST" enctype="multipart-form-data" action="loginUser">
                @csrf
            <fieldset>
                @error('main')
                <div class="error animDance" >
                    {{$message}}
                </div>
                @enderror
                <h2>Login</h2>


                <div class="formGroup">
                    <label for="#email">Email</label>
                    <input type="email" name="email" id="email" value="@if(isset($email)){{$email}}@endif">
                    <span class="errorText">@error("email"){{$message}}@enderror</span>
                </div>

                <div class="formGroup">
                    <label for="#password">Password</label>
                    <input type="password" id="password" name="password">
                    <span class="errorText">@error("password"){{$message}}@enderror</span>
                </div>
                <input type="submit" class="btn" value="Login" name="submit">
                <p>Don't have an account? <a href="{{route('signup')}}" class="anchor">Signup</a></p>
            </fieldset>
            </form>
        </div>
    </div>
@endsection