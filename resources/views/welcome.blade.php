<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <link href="{{asset('bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin-login.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin-login.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800&amp;display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800&amp;display=swap"
          rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript" src="{{ \Illuminate\Support\Facades\URL::asset('jquery/3.5.1/jquery.min.js')}}"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fbfbfb!important">
    <a class="navbar-brand" href="{{ url('/') }}">Sms App</a>
{{--    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">--}}
{{--        <span class="navbar-toggler-icon"></span>--}}
{{--    </button>--}}

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    {{--        <ul class="navbar-nav mr-auto">--}}
    {{--        </ul>--}}
    {{--        <form class="form-inline my-2 my-lg-0">--}}
    {{--        </form>--}}
    </div>
</nav>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
            <h4 style="color: #0d0d0d" class="mt-4 mb-3">Staff Login</h4>
            @if($errors->any())
                <div class="alert alert-danger">
                    <h4>{{$errors->first()}}</h4>
                </div>
            @endif
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ url('login-staff') }}">
            @csrf
            <input type="text" id="email" class="fadeIn second" name="email" placeholder="email">
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
            <input type="submit" class="fadeIn fourth" value="Log In">
        </form>

        <!-- Remind Passowrd -->
        <div id="formFooter">
            <a class="underlineHover" href="#">Forgot Password?</a>
        </div>

    </div>
</div>
</body>
</html>
<script>
    $("#login-button").click(function(event){
        event.preventDefault();

        $('form').fadeOut(500);
        $('.wrapper').addClass('form-success');
    });
</script>
