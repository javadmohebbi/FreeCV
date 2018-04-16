<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ getWebTitle(App::getLocale()) }}</title>

    <meta name="keywords" content="{{ getWebKeywords(App::getLocale()) }}" />


    <meta name="description" content="{{ getWebDescription(App::getLocale()) }}" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset("public/vendor/bootstrap-3.3.7-dist/css/bootstrap.min.css") }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("public/vendor/font-awesome-4.7.0/css/font-awesome.min.css") }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset("public/vendor/ionicons-2.0.1/css/ionicons.min.css") }}">


    <link rel="icon"
          type="image/png"
          href="{{ asset('public/img/fav.ico') }}">



    <!-- Theme style -->
    @if (!isRTL())
    <link rel="stylesheet" href="{{ asset("public/vendor/adminlte/dist/css/AdminLTE.min.css") }}">
    @endif

    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="{{ asset("public/vendor/adminlte/dist/css/skins/skin-black.min.css") }}">




    @if (isRTL())
        <link rel="stylesheet" href="{{ asset("public/vendor/bootstrap-rtl-master/dist/css/bootstrap-rtl.min.css") }}">
        <link rel="stylesheet" href="{{ asset("public/vendor/adminlte-rtl/dist/css/AdminLTE-rtl.css") }}">
        <link rel="stylesheet" href="{{ asset("public/vendor/adminlte-rtl/dist/css/skins/_all-skins-rtl.min.css") }}">
    @endif


    <!-- Data Table -->
    <link rel="stylesheet" href="{{ asset("public/vendor/datatable/jquery.dataTables.min.css") }}">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:/ -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{ asset('public/vendor/html5shiv/html5shiv.min.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('public/vendor/html5shiv/respond.min.js') }}"></script>
    <![endif]-->


    <!-- Bootstrap Toggle -->
    <link rel="stylesheet" href="{{ asset("public/vendor/bootstrap-toggle/bootstrap-toggle.min.css") }}">



    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/bYekan/B_yekan.css') }}"/>

    <style type="text/css">
        .open-sans {
            font-family: Open Sans;
        }
        .yekan {
            font-family: B Yekan, 'B Yekan';
        }
    </style>



    <link rel="stylesheet" href="{{ asset("public/css/openCV.css") }}">


    @yield('pageStyle')


    <!-- CUSTOM CSS -->
    <style type="text/css">
        {!! getCustomCss(App::getLocale()) !!}
    </style>


</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition fixed skin-black sidebar-mini">
<div class="wrapper">

    <!-- Header -->
    @include('templates.modules.header');

    <!-- Sidebar -->
    @include('templates.modules.sidebar')


    <!-- Content -->
    @yield('content')



    <!-- Footer -->
    @include('templates.modules.footer')


    <!-- Control Panel Tab Side Bar -->
    @include('templates.modules.cp_sidebar')


</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<!--<script src="{{ asset('public/js/app.js') }}"></script>-->


<!-- jQuery 2.2.3 -->
<script type="text/javascript" src="{{ asset("public/vendor/jquery-3.2.1/jquery-3.2.1.min.js") }}"></script>
<!-- Bootstrap 3.3.6 -->
<script type="text/javascript" src="{{ asset("public/vendor/bootstrap-3.3.7-dist/js/bootstrap.min.js") }}"></script>

<!-- AdminLTE Option -->
<script type="text/javascript" >
    var AdminLTEOptions = {
        //Enable sidebar expand on hover effect for sidebar mini
        //This option is forced to true if both the fixed layout and sidebar mini
        //are used together
        sidebarExpandOnHover: false,
        //BoxRefresh Plugin
        enableBoxRefresh: true,
        //Bootstrap.js tooltip
        enableBSToppltip: true,

        //Activate sidebar slimscroll if the fixed layout is set (requires SlimScroll Plugin)
        sidebarSlimScroll: true
    };
</script>



<!-- SlimScroll -->
<script type="text/javascript" src="{{ asset("public/vendor/adminlte/plugins/slimScroll/jquery.slimscroll.min.js") }}"></script>


<!-- AdminLTE App -->
<script type="text/javascript" src="{{ asset("public/vendor/adminlte/dist/js/app.min.js") }}"></script>


<script type="text/javascript">
    $(document).on('click', 'a.goto', function(event){
        event.preventDefault();

        $('html, body').animate({
            scrollTop: $( $.attr(this, 'href') ).offset().top
        }, 1000);
    });



    $(window).on('load', function() {
        $kbGrid.masonry();
    });




</script>

<!-- Page Script -->
@yield('pageScripts')




<!-- Bootstrap Toggle -->
<script type="text/javascript" src="{{ asset("public/vendor/bootstrap-toggle/bootstrap-toggle.min.js") }}"></script>



<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->


<!-- OPEN CV APP -->
<script type="text/javascript" src="{{ asset("public/js/openCV.js") }}"></script>



<!-- CUSTOM JS -->
<script type="text/javascript">
{!! getCustomJs(App::getLocale()) !!}
</script>


<!-- Google Analytics -->

    {!!  getGoogleAnalytics(App::getLocale()) !!}





</body>
</html>
