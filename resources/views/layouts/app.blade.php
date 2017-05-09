<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" ng-app="LaRose">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') </title>
    <link rel="icon" href="{{ asset('icon_logo.png') }}"/>

    {{-- CÁC FILE CSS --}}
    <link href="{{ asset('css/w3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <link href="{{ asset('css/angucomplete.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-chart.js/1.1.1/angular-chart.min.js"></script>
    <style>
        .hero-image {
            /* The image used */
            background-image: url( '{{asset('bg.jpg')}}' );

            /* Set a specific height */
            height: 100%;

            /* Position and center the image to scale nicely on all screens */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
        }
    </style>
</head>

<body ng-cloak>
    {{-- NẾU LÀ KHÁCH YÊU CẦU ĐĂNG NHẬP --}}
    @if(Auth::guest())
        @yield('content')
    @else
        @include('layouts/header')
        {{-- DANH SÁCH CÁC CHỨC NĂNG --}}
        @include('layouts.catalog')
        {{-- NỘI DUNG --}}
        <div id="main" class="w3-main" style="margin-left:200px; padding: 10px">
            <ol class="breadcrumb w3-blue-grey ">
                <li class="breadcrumb-item"><a href="{{route('home')}}" style="color: white"> Trang chủ </a></li>
                @yield('location')
            </ol>
            @yield('content')
        </div>
    @endif

    {{-- THƯ VIỆN JAVASCRIPT --}}
    {{--<script async src="{{asset('js/toastr.js')}}"></script>--}}
    <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>

    {{-- XỬ LÝ ANGULARJS --}}
    <script src="{{ asset('angularJS/dirPagination.js') }}"></script>
    <script src="{{ asset('angularJS/cleave-angular.min.js') }}"></script>
    <script src="{{ asset('angularJS/angucomplete-alt.js') }}"></script>
    <script src="{{ asset('angularJS/Config.js') }}"> </script>
    <script src="{{ asset('angularJS/HomeController.js') }}"> </script>
    @yield('script')
    <script src="{{asset('js/style.js')}}"></script>
</body>
</html>