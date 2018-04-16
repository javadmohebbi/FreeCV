@extends('templates.cv_templates')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1> <!-- Info Box Header -->
                <i class="fa fa-user-plus"></i>
                {{ trans('ocv.register') }}
            </h1>

        </section>

        <section class="content" style="min-height: 320px">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
            @include('auth.register-from')
            </form>

        </section>

    </div>
@endsection