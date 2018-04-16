<!-- Side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">


        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!--
                BEGIN Content
            -->
            @if (isKbActive(App::getLocale()))
            <li class="header">
                {{ trans('ocv.kb') }}
            </li>
            <li>
                <a href="{{ url(App::getLocale() . '/#kb') }}" class="">
                    <i class="fa fa-newspaper-o"></i>
                    <span>
                        {{ trans('ocv.kb') }}
                    </span>
                </a>
            </li>
            @endif
            <li class="header">
                {{ trans('ocv.most_used_tags') }}
            </li>
            @if (count(getMostUsedTags()))
                @foreach(getMostUsedTags() as $tag)
                    <li>
                        <a href="{{ url(App::getLocale() . '/hashtag/'. $tag->tag) }}" class="">
                            <i class="fa fa-hashtag"></i>
                            <span>
                                {{ $tag->tag  }}
                            </span>
                            @if (isRTL())
                            <span class="pull-left-container">
                            @else
                            <span class="pull-right-container">
                            @endif
                                <span class="label bg-red @if(isRTL()) pull-left @else pull-right @endif">
                                    {{ $tag->count }}
                                </span>
                            </span>
                        </a>
                    </li>
                @endforeach
            @endif

            <!--
                E N D Content
            -->



        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>