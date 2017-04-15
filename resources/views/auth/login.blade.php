@extends('layouts.app')

@section('title')
    Larose | @lang('login.login')
@endsection

@section('content')
<div class="w3-main">
    <div class="panel w3-text-blue-gray">
        <div class="panel-heading" align="center">
            <img src="{{asset('logo.png')}}" height="200">
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
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
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
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
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

                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            @lang('login.forget_pass')
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
