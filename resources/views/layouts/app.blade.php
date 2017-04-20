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
    <link href="{{ asset('css/w3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
    <style>
        a {
            color: black;
        }
        a:hover {
            text-decoration: none;
            color: white;
        }
        .image {
            opacity: 1;
            display: block;
            width: 50%;
            height: auto;
            transition: .5s ease;
            backface-visibility: hidden;
        }

        .middle {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%)
        }
        .image:hover {
            opacity: 0.3;
        }
        .middle:hover {
            opacity: 1;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
</head>

<body ng-cloak>
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
                <li class="breadcrumb-item"><a href="{{route('home')}}" style="color: white"> Trang chủ </a></li>
                @yield('location')
            </ol>
            @yield('content')
        </div>
    @endif

    <!-- Libary JavaScript -->
    <script src="{{asset('js/toastr.js')}}"></script>
    <script src="{{asset('js/validate.js')}}"></script>
    <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>

    <!-- Scripts -->
    <script src="{{ asset('angularJS/dirPagination.js') }}"></script>
    <script src="{{ asset('angularJS/cleave-angular.min.js') }}"></script>
    <script src="{{ asset('angularJS/cleave-phone.vn.js') }}"></script>
    <script src="{{ asset('angularJS/Config.js') }}"> </script>
    @yield('script')
    <script>
        // Get the Sidebar
        var mySidebar = document.getElementById("mySidebar");


        // Toggle between showing and hiding the sidebar, and add overlay effect
        function w3_open() {
            if (mySidebar.style.display === 'block') {
                mySidebar.style.display = 'none';
            } else {
                mySidebar.style.display = 'block';
            }
        }

        // Close the sidebar with the close button
        function w3_close() {
            mySidebar.style.display = "none";
        }

        $.fn.modal.Constructor.prototype.enforceFocus = function() {
            modal_this = this
            $(document).on('focusin.modal', function (e) {
                if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length
                    && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select')
                    && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
                    modal_this.$element.focus()
                }
            })
        };

        toastr.options = {
            "positionClass": "toast-bottom-right",
            "preventDuplicates": true,
        };

        $('input[type="text"]')
            .on('invalid', function(){
                return this.setCustomValidity('Vui lòng nhập thông tin.');
            })
            .on('input', function(){
                return this.setCustomValidity('');
            });

        $('input[type="email"]')
            .on('invalid', function(){
                return this.setCustomValidity('Vui lòng nhập Email.');
            })
            .on('input', function(){
                return this.setCustomValidity('');
            });

        $('input[type="number"]')
            .on('invalid', function(){
                return this.setCustomValidity('Vui lòng nhập số');
            })
            .on('input', function(){
                return this.setCustomValidity('');
            });

    </script>

</body>
</html>
