@extends('layouts.portal')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Edit user: {{ $user->username }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($user, ['action' => ['UsersController@update', $user->id],  'method' => 'put', 'autocomplete' => 'off']) !!}

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="creditCardNumber">Username</label>
                            {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Username', 'required']); !!}

                            @if ($errors->has('username'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="creditCardNumber">Email</label>
                            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'email@domain.com', 'required']); !!}

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group{{ $errors->has('alias') ? ' has-error' : '' }}">
                            <label for="creditCardNumber">BIN</label>
                            {!! Form::text('alias', null, ['class' => 'form-control', 'placeholder' => '123456', 'required']); !!}

                            @if ($errors->has('alias'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('alias') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="creditCardNumber">Role</label>
                            <select name="role" id="role" class="form-control">
                                @if($user->hasRole('admin'))
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $role->id == 1? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                @else
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $role->id == 2? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Password *Leave blank if not password reset is needed</label>

                            {!! Form::password('new_password', ['class' => 'form-control']); !!}

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{--
                        <div class="form-group">
                            <label for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>--}}

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
