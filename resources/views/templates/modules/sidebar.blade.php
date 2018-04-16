<!-- Side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">




        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!--
                BEGIN About
            -->
            <li class="header">
                {{ trans('ocv.about_me') }}
            </li>
            @if (isBioActive(App::getLocale()))
            <li>
                <a href="#bio" class="goto">
                    <i class="fa fa-question-circle"></i>
                    <span>
                        {{ trans('ocv.bio_and_about_me') }}
                    </span>

                </a>
            </li>
            @endif
            @if (isProjectActive(App::getLocale()))
            <li>
                <a href="#projects" class="goto">
                    <i class="fa fa-cubes"></i>
                    <span>
                        {{ trans('ocv.projects') }}
                    </span>
                </a>
            </li>
            @endif
            @if (isSkillActive(App::getLocale()))
            <li>
                <a href="#skills" class="goto">
                    <i class="fa fa-check-square"></i>
                    <span>
                        {{ trans('ocv.skills') }}
                    </span>
                </a>
            </li>
            @endif
            @if (isExperiencesActive(App::getLocale()))
            <li>
                <a href="#experiences" class="goto">
                    <i class="fa fa-mortar-board"></i>
                    <span>
                        {{ trans('ocv.experiences_and_education') }}
                    </span>
                </a>
            </li>
            @endif
            @if (isContactActive(App::getLocale()))
            <li>
                <a href="#contact" class="goto">
                    <i class="fa fa-share-alt-square"></i>
                    <span>
                        {{ trans('ocv.contact_me') }}
                    </span>
                </a>
            </li>
            @endif
            <!--
                END About
            -->


            <!--
                BEGIN Content
            -->
            @if (isKbActive(App::getLocale()))
            <li class="header">
                {{ trans('ocv.other_content') }}
            </li>
            <li>
                <a href="#kb" class="goto">
                    <i class="fa fa-newspaper-o"></i>
                    <span>
                        {{ trans('ocv.kb') }}
                    </span>
                </a>
            </li>
            @endif
            <!--
                E N D Content
            -->



        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>