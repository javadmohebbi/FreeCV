@extends('templates.cv_templates')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1> <!-- Info Box Header -->
                <i class="fa fa-refresh"></i>
                {{ trans('ocv.reset_password') }}
            </h1>

        </section>

        <section class="content" style="min-height: 320px">

            <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">{{ trans('ocv.email') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            {{ trans('ocv.send_reset_password_link') }}
                        </button>
                    </div>
                    <div class="col-md-6 col-md-offset-4 text-info">
                        {{ session('status') }}
                    </div>
                </div>
            </form>

        </section>

    </div>
@endsection