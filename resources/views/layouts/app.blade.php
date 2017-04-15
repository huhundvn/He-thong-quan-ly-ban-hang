<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" ng-app="LaRose">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title') </title>
    <link rel="icon" href="{{asset('icon_logo.png')}}"/>
    <!-- Styles -->
    <link href="{{ asset('css/angucomplete.css') }}" rel="stylesheet">
    <link href="{{ asset('css/w3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
</head>

<body>
    @include('layouts/header')
    <!-- if guest then display login -->
    @if(Auth::guest())
        <!-- !ĐĂNG NHẬP! -->
            @yield('content')
    @else
        <!-- !DANH SÁCH CHỨC NĂNG! -->
        @include('layouts.catalog')
        <!-- !NỘI DUNG CHÍNH! -->
        <div id="main" class="w3-main" style="margin-left:200px; padding: 10px">
            <ol class="breadcrumb w3-animate-zoom w3-blue-grey ">
                <li class="breadcrumb-item"><a href="{{route('home')}}"> Trang chủ </a></li>
                @yield('location')
            </ol>
            @yield('content')
        </div>
    @endif

    <!-- Libary JavaScript -->
    <script src="{{ asset('js/toastr.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
    <!-- Scripts -->
    <script src="{{ asset('angularJS/dirPagination.js') }}"></script>
    <script src="{{ asset('angularJS/cleave-angular.min.js') }}"></script>
    <script src="{{ asset('angularJS/cleave-phone.vn.js') }}"></script>
    <script src="{{ asset('angularJS/angucomplete-alt.js') }}"></script>
    <script src="{{ asset('angularJS/Config.js') }}"> </script>
    @yield('script')
</body>
</html>
