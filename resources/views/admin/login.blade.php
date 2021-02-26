<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <link href="{{asset('bootstrap.min.css')}}" rel="stylesheet">
{{--    <link href="{{asset('css/admin-login.css')}}" rel="stylesheet">--}}
{{--    <link href="{{asset('css/admin-login.css')}}" rel="stylesheet">--}}
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800&amp;display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800&amp;display=swap"
          rel="stylesheet">
{{--    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>--}}
    <script type="text/javascript" src="{{ \Illuminate\Support\Facades\URL::asset('jquery/3.5.1/jquery.min.js')}}"></script>

    <style>
        .login-block{
            background: #05728f;  /* fallback for old browsers */
            /*background: -webkit-linear-gradient(to bottom, #FFB88C, #DE6262);  !* Chrome 10-25, Safari 5.1-6 *!*/
            /*background: linear-gradient(to bottom, #FFB88C, #DE6262); !* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ *!*/
            float:left;
            width:100%;
            height: 100vh;
            padding : 50px 0;
        }
        .banner-sec{background:url(/pexels-photo.jpg)  no-repeat left bottom; background-size:cover; min-height:500px; border-radius: 0 10px 10px 0; padding:0;}
        .container{background:#fff; border-radius: 10px; box-shadow:15px 20px 0px rgba(0,0,0,0.1);}
        .carousel-inner{border-radius:0 10px 10px 0;}
        .carousel-caption{text-align:left; left:5%;}
        .login-sec{padding: 50px 30px; position:relative;}
        .login-sec .copy-text{position:absolute; width:80%; bottom:20px; font-size:13px; text-align:center;}
        .login-sec .copy-text i{color:#05728f;}
        .login-sec .copy-text a{color:#05728f;}
        .login-sec h2{margin-bottom:30px; font-weight:800; font-size:30px; color: #05728f;}
        .login-sec h2:after{content:" "; width:100px; height:5px; background:#05728f; display:block; margin-top:20px; border-radius:3px; margin-left:auto;margin-right:auto}
        .btn-login{background: #05728f; color:#fff; font-weight:600;}
        .banner-text{width:70%; position:absolute; bottom:40px; padding-left:20px;}
        .banner-text h2{color:#fff; font-weight:600;}
        .banner-text h2:after{content:" "; width:100px; height:5px; background:#FFF; display:block; margin-top:20px; border-radius:3px;}
        .banner-text p{color:#fff;}
    </style>
</head>

<body>
{{--<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fbfbfb!important">--}}
{{--    <a class="navbar-brand" href="{{ url('/') }}">Sms App</a>--}}
{{--    <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--    </div>--}}
{{--</nav>--}}
{{--<div class="wrapper fadeInDown">--}}
{{--    <div id="formContent">--}}
{{--        <!-- Tabs Titles -->--}}

{{--        <!-- Icon -->--}}
{{--        <div class="fadeIn first">--}}
{{--            <h4 style="color: #0d0d0d" class="mt-4 mb-3">Admin Login</h4>--}}
{{--            @if($errors->any())--}}
{{--                <div class="alert alert-danger">--}}
{{--                    <h4>{{$errors->first()}}</h4>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}

{{--        <!-- Login Form -->--}}
{{--        <form method="POST" action="{{ route('login') }}">--}}
{{--            @csrf--}}
{{--            <input type="text" id="email" class="fadeIn second" name="email" placeholder="email">--}}
{{--            <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">--}}
{{--            <input type="submit" class="fadeIn fourth" value="Log In">--}}
{{--        </form>--}}

{{--        <!-- Remind Passowrd -->--}}
{{--        <div id="formFooter">--}}
{{--            <a class="underlineHover" href="#">Forgot Password?</a>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--</div>--}}

<section class="login-block">
    <div class="container">
        <div class="row">
            <div class="col-md-4 login-sec">

                <h2 class="text-center">SMS APP</h2>

                <h3 class="text-center">Login Now</h3><br>
                <form class="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="text-uppercase">Username</label>
                        <input type="text" class="form-control" placeholder="" id="email" name="email" required>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="text-uppercase">Password</label>
                        <input type="password" class="form-control" placeholder="" id="password" name="password" required>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h4>{{$errors->first()}}</h4>
                        </div>
                    @endif
                    <div class="form-check">
                        <button type="submit" class="btn btn-login float-right">Submit</button>
                    </div>

                </form>
            </div>
            <div class="col-md-8 banner-sec">

            </div>
        </div>
</section>
</body>
</html>

<script>
    $("#login-button").click(function(event){
        event.preventDefault();

        $('form').fadeOut(500);
        $('.wrapper').addClass('form-success');
    });
</script>


