@extends('templates.error_templates')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">

        </section>


        <section id="bioSection" class="content" style="min-height: 320px">
            <h1 id="bio">
                <i class="fa fa-times-circle text-danger"></i>
                {{ trans('ocv.error_500') }}
            </h1>

            <p class="text-justify" style="font-size: 140%;">
                {{ trans('ocv.error_500_msg') }}
            </p>

            <p class="text-justify" style="font-size: 140%;">
                {{ trans('ocv.error_game') }}
                <a class="btn btn-info btn-flat" href="{{ url(App::getLocale() . '/') }}">
                    <i class="fa fa-globe"></i>
                    {{ trans('ocv.homepage') }}
                </a>
            </p>

            <div class="row" >
                <div class="col-md-5 col-md-offset-3" style="overflow: hidden; border:1px solid rgba(96,96,96,0.93)">
                    @include('errors.game')
                </div>
            </div>

        </section>
    </div>


@endsection


@section('pageStyle')

    <link rel="stylesheet" href="{{ asset('public/vendor/game/t-rex-runner-gh-pages/index.css')  }}">

    <style type="text/css">
        div.error {
            @if (isRTLForInstallation(App::getLocale()))
                text-align: right;
            @else
                text-align: left;
        @endif
        }
    </style>
@endsection

@section('pageScripts')


    <script src="{{ asset('public/vendor/game/t-rex-runner-gh-pages/index.js')  }}"></script>



@endsection


