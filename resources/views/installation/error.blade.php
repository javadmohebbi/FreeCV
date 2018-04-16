<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">



    <!-- CACHE CONTROL -->
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />


    <link rel="icon"
          type="image/png"
          href="{{ asset('public/img/fav.ico') }}">


    @if (isRTLForInstallation(App::getLocale()))
        <link rel="stylesheet" href="{{ asset("public/vendor/bootstrap-rtl-master/dist/css/bootstrap-rtl.min.css") }}">

    @endif


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script type="text/javascript" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/bYekan/B_yekan.css') }}"/>

    <style type="text/css">
        .open-sans {
            font-family: Open Sans;
        }
        .yekan {
            font-family: B Yekan, 'B Yekan';
        }
        .box-with-shadow {
            background: #ffffff;
            box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
            padding: 20px;
        }
        .full-height {
            height:100vh;
        }
        .title {
            padding-bottom: 10px;
        }
        .logo {
            @if (isRTLForInstallation(App::getLocale()))
                padding-left: 10px;
            @else
                padding-right: 10px;
            @endif
        }
        h1 {
            font-size: 18px;
            font-weight: 700;

        }
        div.line {
            border-bottom: 2px solid grey;
            margin-bottom: 20px;
        }
       .form-control{
            border-color: #2DB8FF;
        }
        .has-error {
            border-color: red;
        }
        .btn-success {
            background: #2DB8FF;
        }
        .btn-success:hover, .btn-success:active, .btn-success:toggle {
            background: #2493cc;
        }
    </style>


    <link rel="stylesheet" href="{{ asset("public/css/openCV.css") }}">


</head>
<body class="">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-8 col-md-offset-2  box-with-shadow">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="logo @if(isRTLForInstallation(App::getLocale())) pull-right @else pull-left @endif">
                            <img class="img-responsive" src="{{ asset('public/img/ocv.png') }}" style="width: 50px" />
                        </div>
                        <div class="title">
                            <h1>
                                {{ trans('ocv.openCv') }}
                            </h1>
                            <p>
                                {{ trans('ocv.openCvDesc') }}
                            </p>
                            <p>
                                <a href="http://mjmohebbi.com" target="_blank">
                                    MJMOHEBBI.COM
                                </a>&nbsp;|&nbsp;
                                <a href="mailto:me@mjmohebbi.com">
                                    ME [@] MJMOHEBBI [DOT] COM
                                </a>
                            </p>
                            <div class="btn-group">
                                <a class="btn btn-default" href="{{ url('/en/install') }}">
                                    {{ trans('ocv.installation_en') }}
                                </a>
                                <a class="btn btn-default" href="{{ url('/fa/install') }}">
                                    {{ trans('ocv.installation_fa') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="line"></div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">


                                <div class="col-sm-12 bg-danger" style="margin-top: 10px">
                                    <span class="" style="font-size: 150%">
                                        {{ $error }}
                                    </span>
                                </div>


                                <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                    <a href="{{ url('/install') }}"
                                           class="btn btn-success"
                                           style="width: 100%"
                                            >
                                        {{ trans('ocv.installation_back_to_wizard') }}
                                    </a>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<!-- Scripts -->
<script src="{{ asset('public/js/app.js') }}"></script>
</body>
</html>
