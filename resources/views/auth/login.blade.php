@extends('layouts.app')

@section('title')
    Đăng nhập
@endsection

@section('content')
<div class="container">
<form id="form-login" class="form-horizontal" role="form" method="POST" action="{{ route('login') }}"> {{ csrf_field() }}
    <img src="{{asset('logo.png')}}" height="300">
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
    <div class="col-md-2"></div>
    <div class="col-md-10">
        <button type="submit" class="btn w3-blue-grey"> Đăng nhập </button>
    </div>
</form>
</div>
@endsection
