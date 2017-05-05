@extends('layouts.app')

@section('title')
    Đăng nhập
@endsection

@section('content')
<div class="w3-main" style="height: 650px;">
    <div class="panel w3-text-blue-gray bg">
        <div class="panel-heading" align="center">
            <img src="{{asset('logo.png')}}" height="300">
        </div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}"> {{ csrf_field() }}

                <div class="form-group {{ $errors->has('email') ? ' has-error' : ''}}">
                    <label for="email" class="col-md-4 control-label">
                        <span class="glyphicon glyphicon-user"></span>
                    </label>
                    <div class="col-md-4">
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
                    <label for="password" class="col-md-4 control-label">
                        <span class="glyphicon glyphicon-lock"></span>
                    </label>
                    <div class="col-md-4">
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
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label style="color: white">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('login.remember')
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn w3-blue-grey">
                            @lang('login.login')
                        </button>
                        <a class="btn btn-link" href="{{ route('password.request') }}" style="color: white">
                            @lang('login.forget_pass')
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
