<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url(App::getLocale()) }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span id="header-logo-mini" class="logo-mini">{{ substr(getWebMenuShort(App::getLocale()), 0,3) }}</span>
        <!-- logo for regular state and mobile devices -->
        <span id="header-logo-lg" class="logo-lg">{{ getWebMenuLong(App::getLocale()) }}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- Internationalization -->
                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-globe"></i>
                        {{ trans('ocv.language') }}
                        <span class="label label-info">
                            {{ App::getLocale() }}
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            @foreach(getAllLanguages() as $lang)
                            <a href="{{ url('/' . $lang->short) }}">
                                {{ $lang->name }} - ({{$lang->short}})
                            </a>
                            @endforeach
                        </li>
                        @if(\App\User::isAdmin())
                            <li>
                                <a id="btnManageLang" href="javascript:void(0);">
                                    <i class="fa fa-cog"></i>
                                    {{ trans('ocv.language_management') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>


            @if (Auth::check())

                <!-- Notifications Menu -->
                @if(\App\User::isAdmin())
                <li class="dropdown notifications-menu" id="notofication-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span id="not-icon">
                        @if (count(getUnreadComments()) == 0)
                            <i class="fa fa-bell-o"></i>
                        @else
                            <i class="text-info fa fa-bell"></i>
                        @endif
                        </span>
                        <span id="not-flag-count" class="label label-warning">
                            {{ count(getUnreadComments()) }}
                        </span>
                    </a>
                    <ul class="dropdown-menu">

                        <li>
                            <!-- Inner Menu: contains the notifications -->
                            <ul class="menu">
                                @if (count(getUnreadComments()) > 0)
                                <li id="not-comments"><!-- start notification -->
                                    <a href="javascript:void(0);" id="btnUnreadComments" title="{{ trans_choice('ocv.msg_unread_comments_no_html', getUnreadComments(), ['count' => count(getUnreadComments())] ) }}">
                                        <i class="fa fa-comments"></i>
                                        {!! trans_choice('ocv.msg_unread_comments', getUnreadComments(), ['count' => count(getUnreadComments())] )  !!}

                                    </a>
                                </li>
                                @else
                                <li id="not-comments"><!-- start notification -->
                                    <a href="javascript:void(0);">
                                        <i class="fa fa-exclamation-triangle"></i>
                                        {{ trans('ocv.dt_empty') }}
                                    </a>
                                </li>
                                @endif
                                <!-- end notification -->
                            </ul>
                        </li>

                        <!--<li class="footer"><a href="#">View all</a></li>-->
                    </ul>
                </li>
                @endif


                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ asset("public/vendor/adminlte/dist/img/male.png") }}" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">
                            {{ getUsername() }}
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ asset("public/vendor/adminlte/dist/img/male.png") }}" class="img-circle" alt="User Image">
                            <p>
                                {{ getUsername() }}
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <!--<div class="pull-left">
                                <a href="javascript:void(0);"
                                   id="btnProfile"
                                   class="btn btn-info btn-xs btn-flat">{{ trans('ocv.profile') }}</a>
                            </div>-->
                            <div class="pull-right">
                                <form action="{{ url("logout") }}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" value="{{ trans('ocv.signout') }}" class="btn btn-danger btn-xs btn-flat">
                                </form>
                            </div>
                            @if(\App\User::isAdmin())
                                <div class="pull-left">
                                    <a href="javascript:void(0);"
                                       id="btnManageUsers"
                                       class="btn btn-success btn-xs btn-flat">{{ trans('ocv.manage_users') }}</a>
                                </div>
                            @endif
                        </li>
                    </ul>
                </li>


                <!-- Control Sidebar Toggle Button -->
                @if(\App\User::isAdmin())
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
                @endif
            @else
                <!-- Login / Register -->
                <li>
                    <a href="{{ url(App::getLocale() . '/login') }}">
                        {{ trans('ocv.login') }}
                    </a>
                </li>
                <li>
                    <a href="{{ url(App::getLocale() . '/register') }}" >
                        {{ trans('ocv.register') }}
                    </a>
                </li>
            @endif
            </ul>
        </div>
    </nav>
</header>


<!-- Language Management Modal -->
@include('templates.modals.modal-languages')