@extends("layouts.app")
    @section("head")
    <title>Tera Diary</title>
    <script>
        var token ="{{ csrf_token() }}";
    </script>
    @endsection

@section("content")
    <script defer>
        let data={_token:token ,screenSize:window.screen.width,hey:"hello"}
        console.log(data)

        $.post("/simple",data,function (resp){
            console.log(resp);
            window.location.reload()

        })
    </script>
    
@endsection