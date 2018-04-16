@extends('templates.cv_templates')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1> <!-- Info Box Header -->
                <i class="fa fa-sign-in"></i>
                {{ trans('ocv.login') }}
            </h1>

        </section>

        <section class="content" style="min-height: 320px">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">{{ trans('ocv.email') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">{{ trans('ocv.password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required>

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
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ trans('ocv.remember_me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            {{ trans('ocv.login') }}
                        </button>

                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ trans('ocv.forgot_password') }}
                        </a>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
