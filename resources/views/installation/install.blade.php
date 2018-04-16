

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



    <link rel="icon"
          type="image/png"
          href="{{ asset('public/img/fav.ico') }}">


    <!-- CACHE CONTROL -->
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />




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
                            <form class="form-horizontal" action="{{ url(App::getLocale().'/install/check/it') }}"
                                  method="post">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                <!-- BEGIN USER CONFIGURATION -->
                                <div class="col-sm-12">
                                    <div class="col-sm-12 label label-default" style="font-size: 120%;padding: 15px; margin-bottom: 10px">
                                        {{ trans('ocv.installation_USER_CONF') }}
                                    </div>
                                </div>
                                <!-- E N D USER CONFIGURATION -->


                                <!-- BEGIN EMAIL -->
                                <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                    <label>
                                        {{ trans('ocv.installation_USER_EMAIL') }}
                                    </label>
                                    <input name="email" type="text" placeholder="email@example.org" value="{{ old('email') }}"
                                           class="form-control ltr @if ($errors->has('email')) has-error @endif">
                                </div>
                                @if ($errors->has('email'))
                                    <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                        <label class="label label-danger">
                                            {{ $errors->first('email') }}
                                        </label>
                                    </div>
                                @endif
                                <!-- END EMAIL -->



                                <!-- BEGIN PASSWORD -->
                                <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                    <label>
                                        {{ trans('ocv.installation_USER_PASSWORD') }}
                                    </label>
                                    <input name="password" type="password" placeholder="" value=""
                                           class="form-control ltr @if ($errors->has('password')) has-error @endif">
                                </div>
                                @if ($errors->has('password'))
                                    <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                        <label class="label label-danger">
                                            {{ $errors->first('password') }}
                                        </label>
                                    </div>
                                @endif
                                <!-- END PASSWORD -->



                                <!-- BEGIN PASSWORD CONF -->
                                <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                    <label>
                                        {{ trans('ocv.installation_USER_PASSWORD_CONFIRMATION') }}
                                    </label>
                                    <input name="password_confirmation" type="password" placeholder="" value="{{ old('email') }}"
                                           class="form-control ltr @if ($errors->has('password_confirmation')) has-error @endif">
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                        <label class="label label-danger">
                                            {{ $errors->first('password_confirmation') }}
                                        </label>
                                    </div>
                                @endif
                                <!-- END PASSWORD CONF -->








                                <!-- BEGIN DB CONFIGURATION -->
                                <div class="col-sm-12" style="margin-top: 20px">
                                    <div class="col-sm-12 label label-default" style="font-size: 120%;padding: 15px; margin-bottom: 10px">
                                        {{ trans('ocv.installation_DB_CONF') }}
                                    </div>
                                </div>
                                <!-- E N D DB CONFIGURATION -->


                                <!-- BEGIN DB HOST -->
                                <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                    <label>
                                        {{ trans('ocv.installation_DB_HOST') }}
                                    </label>
                                    <input name="db_host" type="text" placeholder="127.0.0.1" value="@if(!old('db_host'))127.0.0.1 @else{{old('db_host')}}@endif"
                                           class="form-control ltr @if ($errors->has('db_host')) has-error @endif">
                                </div>
                                @if ($errors->has('db_host'))
                                    <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                        <label class="label label-danger">
                                            {{ $errors->first('db_host') }}
                                        </label>
                                    </div>
                                @endif
                                <!-- END DB HOST -->


                                <!-- BEGIN DB PORT -->
                                <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                    <label>
                                        {{ trans('ocv.installation_DB_PORT') }}
                                    </label>
                                    <input name="db_port" type="text" placeholder="3306" value="3306"
                                           class="form-control ltr @if ($errors->has('db_port')) has-error @endif">
                                </div>
                                @if ($errors->has('db_port'))
                                    <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                        <label class="label label-danger">
                                            {{ $errors->first('db_port') }}
                                        </label>
                                    </div>
                                @endif
                                <!-- END DB PORT -->


                                <!-- BEGIN DB NAME -->
                                <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                    <label>
                                        {{ trans('ocv.installation_DB_DATABASE') }}
                                    </label>
                                    <input name="db_name" type="text" placeholder="DB" value="@if(!old('db_name'))dbFreeCV @else{{old('db_name')}}@endif"
                                           class="form-control ltr @if ($errors->has('db_name')) has-error @endif">
                                </div>
                                @if ($errors->has('db_name'))
                                    <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                        <label class="label label-danger">
                                            {{ $errors->first('db_name') }}
                                        </label>
                                    </div>
                                @endif
                                <!-- END DB NAME -->


                                <!-- BEGIN DB USER -->
                                <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                    <label>
                                        {{ trans('ocv.installation_DB_USERNAME') }}
                                    </label>
                                    <input name="db_usern" type="text" placeholder="USER: root, ..." value="{{ old('db_usern') }}"
                                           class="form-control ltr @if ($errors->has('db_usern')) has-error @endif">
                                </div>
                                @if ($errors->has('db_usern'))
                                    <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                        <label class="label label-danger">
                                            {{ $errors->first('db_usern') }}
                                        </label>
                                    </div>
                                @endif
                                <!-- END DB USER -->


                                <!-- BEGIN DB PASS -->
                                <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                    <label>
                                        {{ trans('ocv.installation_DB_PASSWORD') }}
                                    </label>
                                    <input name="db_passn" type="text" placeholder="" value="{{ old('db_passn') }}"
                                           class="form-control ltr @if ($errors->has('db_passn')) has-error @endif">
                                </div>
                                @if ($errors->has('db_passn'))
                                    <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                        <label class="label label-danger">
                                            {{ $errors->first('db_passn') }}
                                        </label>
                                    </div>
                                @endif
                                <!-- END DB PASS -->



                                @if ($errors->has('msg'))
                                    <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                        <label class="label label-danger">
                                            {{ $errors->first('msg') }}
                                        </label>
                                    </div>
                                @endif

                                <div class="col-sm-12 col-md-6 col-md-offset-3" style="margin-top: 10px">
                                    <input type="submit"
                                           class="btn btn-success"
                                           style="width: 100%"
                                           value="{{ trans('ocv.installation_button') }}" />
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
