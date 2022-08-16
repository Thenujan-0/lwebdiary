@env("local")
    <link rel="stylesheet" href="{{asset('css/errorPopup.css')}}">

    <script defer src="{{asset('js/errorPopup.js')}}"></script>

@endenv

@env("heroku")
    <link rel="stylesheet" href="{{secure_asset('css/errorPopup.css')}}">

    <script defer src="{{secure_asset('js/errorPopup.js')}}"></script>

@endenv
<div class="errorPopupContainer">
    <div class="errorPopup">
        <h1>Hello there</h1>
        <button class="btn">Close</button>
    </div>
</div>