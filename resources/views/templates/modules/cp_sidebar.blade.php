<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark" >
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-web-tab" data-toggle="tab"><i class="fa fa-globe"></i></a></li>
        <li><a href="#control-sidebar-setting-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>

    </ul>
    <!-- Tab panes -->
    <div class="tab-content" >
        <!-- tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading"><i class="fa fa-home"></i> {{ trans('ocv.web_site_settings') }}</h3>
            <ul class="control-sidebar-menu">
                <li>{!! getEnabledBio(App::getLocale()) !!}</li>
                <li>{!! getEnabledProject(App::getLocale()) !!}</li>
                <li>{!! getEnabledSkill(App::getLocale()) !!}</li>
                <li>{!! getEnabledExperience(App::getLocale()) !!}</li>
                <li>{!! getEnabledContact(App::getLocale()) !!}</li>
                <li>{!! getEnabledKb(App::getLocale()) !!}</li>
            </ul>
        </div>

        <div class="tab-pane" id="control-sidebar-web-tab">
            <h3 class="control-sidebar-heading"><i class="fa fa-globe"></i> {{ trans('ocv.web_site_information_settings') }}</h3>
            <ul class="control-sidebar-menu" style="word-wrap: break-word">
                <li class="form-group">
                    <label class="label">
                        {{ trans('ocv.web_title') }}
                    </label>
                    <input id="web-info-title" type="text" class="form form-control"
                           value="{{ getWebTitle(App::getLocale()) }}"
                           placeholder="{{ trans('ocv.web_title') }}" />
                </li>
                <li class="form-group">
                    <label class="label">
                        {{ trans('ocv.web_keywords') }}
                    </label>
                    <input id="web-info-keywords" type="text" class="form form-control"
                           value="{{ getWebKeywords(App::getLocale()) }}"
                           placeholder="{{ trans('ocv.web_keywords') }}" />
                    <label class="label label-warning">
                        {{ trans('ocv.separated_by_coma') }}
                    </label>
                </li>
                <li class="form-group">
                    <label class="label">
                        {{ trans('ocv.description') }}
                    </label>
                    <textarea id="web-info-desc" style="resize: none;" class="form form-control">{{ getWebDescription(App::getLocale()) }}</textarea>
                </li>


                <li class="form-group">
                    <label class="label">
                        {{ trans('ocv.web_menu_title_long') }}
                    </label>
                    <input id="web-menu-long" type="text" class="form form-control"
                           maxlength="10"
                           value="{{ getWebMenuLong(App::getLocale()) }}"
                           placeholder="{{ trans('ocv.web_menu_title_long') }}" />
                </li>


                <li class="form-group">
                    <label class="label">
                        {{ trans('ocv.web_menu_title_short') }}
                    </label>
                    <input id="web-menu-short" type="text" class="form form-control"
                           maxlength="3" size="3"
                           value="{{ getWebMenuShort(App::getLocale()) }}"
                           placeholder="{{ trans('ocv.web_menu_title_short') }}" />
                </li>



                <li class="form-group">
                    <a id="btnSaveWebInfo" style="margin: auto 15px;" class="btn btn-success btn-flat" href="javascript:void(0);">
                        <img class="loading hidden" src="{{ asset('public/img/ajax-loader-spin.gif')}}" alt="loading"/>
                        {{ trans('ocv.save') }}
                    </a>
                    <label id="web-info-status" class="text-white" style="max-width: 220px; margin: 5px 10px">

                    </label>
                </li>

            </ul>
            <!-- /.control-sidebar-menu -->
        </div>


        <div class="tab-pane" id="control-sidebar-setting-tab">
            <h3 class="control-sidebar-heading"><i class="fa fa-gears"></i> {{ trans('ocv.web_site_customization') }}</h3>
            <ul class="control-sidebar-menu" style="word-wrap: break-word">
                <li class="form-group">
                    <label class="label">
                        {{ trans('ocv.custom_css') }}
                    </label>
                    <textarea id="web-custom-css" style="resize: none;" class="form form-control">{{ getCustomCss(App::getLocale()) }}</textarea>
                </li>
                <li class="form-group">
                    <label class="label">
                        {{ trans('ocv.custom_js') }}
                    </label>
                    <textarea id="web-custom-js" style="resize: none;" class="form form-control">{{ getCustomJs(App::getLocale()) }}</textarea>
                </li>

                <li class="form-group">
                    <label class="label">
                        {{ trans('ocv.custom_google_analytics') }}
                    </label>
                    <textarea id="web-google-analytics" style="resize: none;" class="form form-control">{{ getGoogleAnalytics(App::getLocale()) }}</textarea>
                </li>
                <li class="form-group">
                    <a id="btnSaveWebCustomization" style="margin: auto 15px;" class="btn btn-success btn-flat" href="javascript:void(0);">
                        <img class="loading hidden" src="{{ asset('public/img/ajax-loader-spin.gif')}}" alt="loading"/>
                        {{ trans('ocv.save') }}
                    </a>
                    <label id="web-custom-status" class="text-white" style="max-width: 220px; margin: 5px 10px">

                    </label>
                </li>
            </ul>
        </div>
        <!-- /.tab-pane -->

    </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>