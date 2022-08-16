<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @env("local")
        <link rel="icon" type="image/x-icon" href="{{asset('images/logo.svg')}}">
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> --}}
        <script src="{{asset('jquery.js')}}"></script>
        <script src="{{asset('jquery-form.js')}}"></script>
    @endenv

    @env("heroku")
        <link rel="icon" type="image/x-icon" href="{{secure_asset('images/logo.svg')}}">
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> --}}
        <script src="{{secure_asset('jquery.js')}}"></script>
        <script src="{{secure_asset('jquery-form.js')}}"></script>
    @endenv

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.js" integrity="sha512-RTxmGPtGtFBja+6BCvELEfuUdzlPcgf5TZ7qOVRmDfI9fDdX2f1IwBq+ChiELfWt72WY34n0Ti1oo2Q3cWn+kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src="https://kit.fontawesome.com/9c5767853b.js" crossorigin="anonymous"></script>
    @yield("head")
</head>
<body>
    @yield("content")
    
</body>
</html>