@extends('layouts.app')

@section('title')
    Đăng nhập
@endsection

@section('content')
<div class="w3-main" style="height: 648px;">
    <div class="hero-image w3-animate-opacity">
        <div class="hero-text-left">
            {{--<img src="{{asset('logo.png')}}" height="300">--}}
            <h1 class="w3-animate-fading"> Larose </h1>
        </div>
        <div class="hero-text">
            <h1 class="w3-animate-zoom"> Quản lý cửa hàng </h1>
            <hr/>
            <button class="btn btn-success w3-animate-zoom" data-toggle="modal" data-target="#myModal"> Đăng nhập </button>
        </div>
    </div>

    {{--<button class="btn btn-success"> Đăng nhập </button>--}}
    {{--<div class="panel w3-text-blue-gray bg">--}}
        {{--<div class="panel-heading" align="center">--}}
            {{--<img src="{{asset('logo.png')}}" height="300">--}}
        {{--</div>--}}
        {{--<div class="panel-body">--}}
            {{--<form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}"> {{ csrf_field() }}--}}

                {{--<div class="form-group {{ $errors->has('email') ? ' has-error' : ''}}">--}}
                    {{--<label for="email" class="col-md-4 control-label">--}}
                        {{--<span class="glyphicon glyphicon-user"></span>--}}
                    {{--</label>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<input id="email" type="email" class="form-control" name="email"--}}
                               {{--placeholder="@lang('login.email')..." required autofocus>--}}
                        {{--@if ($errors->has('email'))--}}
                            {{--<div class="alert alert-danger alert-dismissable">--}}
                                {{--<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>--}}
                                {{--<strong> Lỗi! </strong> {{ $errors->first('email') }}--}}
                            {{--</div>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">--}}
                    {{--<label for="password" class="col-md-4 control-label">--}}
                        {{--<span class="glyphicon glyphicon-lock"></span>--}}
                    {{--</label>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<input id="password" type="password" class="form-control" name="password"--}}
                               {{--placeholder="@lang('login.pass')..." required>--}}
                        {{--@if ($errors->has('password'))--}}
                            {{--<span class="help-block">--}}
                                {{--<strong> Lỗi! </strong> {{ $errors->first('password') }}--}}
                            {{--</span>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<div class="col-md-6 col-md-offset-4">--}}
                        {{--<div class="checkbox">--}}
                            {{--<label style="color: white">--}}
                                {{--<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('login.remember')--}}
                            {{--</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--<div class="col-md-8 col-md-offset-4">--}}
                        {{--<button type="submit" class="btn w3-blue-grey">--}}
                            {{--@lang('login.login')--}}
                        {{--</button>--}}
                        {{--<a class="btn btn-link" href="{{ route('password.request') }}" style="color: white">--}}
                            {{--@lang('login.forget_pass')--}}
                        {{--</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</form>--}}
        {{--</div>--}}
    {{--</div>--}}
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title w3-text-blue-gray"> Đăng nhập </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}"> {{ csrf_field() }}
                <div class="form-group {{ $errors->has('email') ? ' has-error' : ''}}">
                <label for="email" class="col-md-2 control-label">
                <span class="glyphicon glyphicon-user"></span>
                </label>
                <div class="col-md-10">
                <input id="email" type="email" class="form-control" name="email"
                placeholder="@lang('login.email')..." required autofocus>
                @if ($errors->has('email'))
                <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong> Lỗi! </strong> {{ $errors->first('email') }}
                </div>
                @endif
                </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-2 control-label">
                <span class="glyphicon glyphicon-lock"></span>
                </label>
                <div class="col-md-10">
                <input id="password" type="password" class="form-control" name="password"
                placeholder="@lang('login.pass')..." required>
                @if ($errors->has('password'))
                <span class="help-block">
                <strong> Lỗi! </strong> {{ $errors->first('password') }}
                </span>
                @endif
                </div>
                </div>
                <div class="form-group">
                <div class="col-md-12 col-md-offset-2">
                <div class="checkbox">
                <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('login.remember')
                </label>
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        @lang('login.forget_pass')
                    </a>
                </div>
                </div>
                </div>
            </div>
            <div class="modal-footer" align="left">
                <button type="submit" class="btn w3-blue-grey"> Đăng nhập </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"> Hủy </button>
            </div>
            </form>
        </div>

    </div>
</div>
@endsection
