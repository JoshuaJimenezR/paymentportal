@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 10vh;">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2">
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group text-center">
                    <h3>Payment Portal</h3>
                    <p>Please sign in to continue</p>

                </div>

                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    <label for="username">Username</label>

                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif

                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">
                        Login
                    </button>

                  {{--      <a class="btn btn-link" href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>--}}
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
