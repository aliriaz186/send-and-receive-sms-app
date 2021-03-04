<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <link href="{{asset('bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/stylesheet.css')}}" rel="stylesheet">
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"--}}
{{--          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"--}}
{{--          crossorigin="anonymous">--}}
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript" src="{{ \Illuminate\Support\Facades\URL::asset('bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{ \Illuminate\Support\Facades\URL::asset('jquery/3.5.1/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ \Illuminate\Support\Facades\URL::asset('bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{ \Illuminate\Support\Facades\URL::asset('popper/popper.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
{{--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>--}}
    <style>
        .ajax-loader {
            visibility: hidden;
            background-color: rgba(255,255,255,0.7);
            position: absolute;
            z-index: +1000000 !important;
            width: 100%;
            height:100%;
        }

        .ajax-loader img {
            position: relative;
            top:50%;
            left:50%;
        }
    </style>
</head>
<body>

<div class="ajax-loader">
    <img src="{{ url('/ajax-loader.gif') }}" class="img-responsive" />
</div>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
{{--        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"--}}
{{--                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">--}}
{{--            <span class="navbar-toggler-icon"></span>--}}
{{--        </button>--}}

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            </ul>
{{--            <form class="form-inline my-2 my-lg-0">--}}
{{--                <a style="float: right !important;" class="dropdown-item" href="{{ route('logout-user') }}">--}}
{{--                    {{ __('Logout') }}--}}
{{--                </a>--}}
{{--                <form action="{{ route('logout') }}" method="POST">--}}
{{--                    @csrf--}}
{{--                    <button id="logoutbtn" style="opacity: 0" type="submit"></button>--}}
{{--                </form>--}}
{{--            </form>--}}
        </div>
    </nav>

    <div class="page-wrapper chiller-theme toggled">
        <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
            <i class="fas fa-bars"></i>
        </a>
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <div class="sidebar-brand">
                    <a class="navbar-brand" href="{{ url('/') }}">Sms App</a>
                    <div id="close-sidebar">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <div class="sidebar-header">
                    <div class="user-pic">
                        <img class="img-responsive img-rounded"
                             src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
                             alt="User picture">
                    </div>
                    <div class="user-info">
                            <h4 style="color: white">Welcome Admin!</h4>
                    </div>
                </div>

                <!-- sidebar-search  -->
                <div class="sidebar-menu">
                    <ul>
                        <li class="header-menu">
                            <span>General</span>
                        </li>
                        <li class="" style="border: 1px solid white;border-bottom: 0px">
                            <a href="{{env('APP_URL')}}/home">
                                <i class="fa fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @if(\Illuminate\Support\Facades\Session::get('isAdmin') === true)
                        <li class="" style="border: 1px solid white;border-bottom: 0px">
                            <a href="{{env('APP_URL')}}/staff">
                                <i class="fas fa-user"></i>
                                <span>Staff</span>
                            </a>
                        </li>
                        @endif
                        <li class="" style="border: 1px solid white;border-bottom: 0px">
                            <a href="{{env('APP_URL')}}/customer">
                                <i class="fas fa-users"></i>
                                <span>Customer</span>
                            </a>
                        </li>
                        <li class="" style="border: 1px solid white;border-bottom: 0px">
                            <a href="{{env('APP_URL')}}/chat" >
                                <i class="fas fa-users"></i>
                                <span>Chat <span style="color: white;font-size: 12px;background: red;padding: 2px 7px 2px 5px;border-radius: 10px;margin-left: 4px;" id="chat-count-dynamic"></span></span>
                            </a>
                        </li>
                        <li class="" style="border: 1px solid white;border-bottom: 0px">
                            <a href="{{env('APP_URL')}}/message-template">
                                <i class="fas fa-envelope-open"></i>
                                <span>Messages Templates</span>
                            </a>
                        </li>
                        <li class="" style="border: 1px solid white;">
                            <a href="{{ route('logout-user') }}">
                                <i class="fas fa-user"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-content  -->
        </nav>
        <!-- sidebar-wrapper  -->
        <main class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
        <!-- page-content" -->
    </div>

</div>
<script>
    function logoutUser()
    {
        event.preventDefault();
       document.getElementById('logoutbtn').click();
    }
    function notification_send(pingCount) {
        if (Notification.permission !== 'granted')
            Notification.requestPermission();
        else {
            var notification = new Notification('New Messages', {
                icon: `{{asset('sms.png')}}`,
                body: pingCount + ' New Meesages',
            });
            notification.onclick = function() {
                window.open(`{{url('')}}`);
            };
        }
    }

    $(document).ready(function(){
        if (!Notification) {
            alert('Desktop notifications not available in your browser. Try Chromium.');
            return;
        }

        if (Notification.permission !== 'granted'){
            Notification.requestPermission();
        }

        getCountsFunction();

    });

    function getCountsFunction(){
        $.get(`{{url('get-chat-ping-count')}}`, function(data, status){
            let result = JSON.parse(data);
            document.getElementById('chat-count-dynamic').innerText = result.count;
            if(result.pingCount > 0){
                notification_send(result.pingCount);
            }
        });
        setTimeout(function () {
            getCountsFunction();
        }, 60000)
    }

    jQuery(function ($) {

        $(".sidebar-dropdown > a").click(function () {
            $(".sidebar-submenu").slideUp(200);
            if (
                $(this)
                    .parent()
                    .hasClass("active")
            ) {
                $(".sidebar-dropdown").removeClass("active");
                $(this)
                    .parent()
                    .removeClass("active");
            } else {
                $(".sidebar-dropdown").removeClass("active");
                $(this)
                    .next(".sidebar-submenu")
                    .slideDown(200);
                $(this)
                    .parent()
                    .addClass("active");
            }
        });

        $("#close-sidebar").click(function () {
            $(".page-wrapper").removeClass("toggled");
        });
        $("#show-sidebar").click(function () {
            $(".page-wrapper").addClass("toggled");
        });

    });
</script>
</body>
</html>
