@extends('templates.blog_templates')

@section('content')

    <div class="content-wrapper" style="">


        <!-- KB Belogns to hashtag -->
        @include('templates.hashtag.content-section')



    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection


@section('pageStyle')

    @if(checkIfAdmin())

        <!-- Tags Input -->
        <link rel="stylesheet" href="{{ asset("public//vendor/tagsinput/bootstrap-tagsinput.css") }}">

        <!-- Summer Note -->
        <link rel="stylesheet" href="{{ asset("public//vendor/summernote/summernote.css") }}">



        <!-- CheckBox -->
        <link rel="stylesheet" href="{{ asset("public//vendor/adminlte/plugins/iCheck/all.css") }}">
        <link rel="stylesheet" href="{{ asset("public//vendor/adminlte/plugins/select2/select2.min.css") }}">



        <!-- Datatable -->
        <link rel="stylesheet" href="{{ asset("public//vendor/datatable/jquery.dataTables.min.css") }}">


    @endif

    <!-- Light Box -->
    <link rel="stylesheet" href="{{ asset("public//vendor/lightbox/css/lightbox.min.css") }}">

    <style type="text/css">
        div.error {
            @if (isRTL())
                text-align: right;
            @else
                text-align: left;
        @endif
}
    </style>
@endsection

@section('pageScripts')


    <!-- Cascading Grid -->
    <script type="text/javascript" src="{{ asset("public//vendor/masonry/masonry.pkgd.min.js") }}"></script>


    @if(checkIfAdmin())



        <!-- Tags Input -->
        <script type="text/javascript" src="{{ asset("public//vendor/tagsinput/bootstrap-tagsinput.js") }}"></script>
        <script type="text/javascript" src="{{ asset("public//vendor/typeahead/typeahead.bundle.js") }}"></script>
        <script type="text/javascript" src="{{ asset("public//vendor/typeahead/bloodhound.min.js") }}"></script>


        <!-- Summernote -->
        <script type="text/javascript" src="{{ asset('public//vendor/summernote/summernote.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public//vendor/summernote/summernote-ext-rtl.js') }}"></script>

        <!-- Simple Upload -->
        <script type="text/javascript" src="{{ asset("public//vendor/simpleupload/simpleUpload.min.js") }}"></script>




        <!-- CheckBox -->
        <script type="text/javascript" src="{{ asset("public//vendor/adminlte/plugins/iCheck/icheck.min.js") }}"></script>
        <script type="text/javascript" src="{{ asset("public//vendor/adminlte/plugins/select2/select2.full.min.js") }}"></script>


        <!-- Data table -->
        <script type="text/javascript" src="{{ asset("public//vendor/datatable/jquery.dataTables.min.js") }}"></script>

        <!-- Notidy JS -->
        <script type="text/javascript" src="{{ asset("public//vendor/notifyjs/notify.min.js") }}"></script>


    @endif

    <!-- Light Box -->
    <script type="text/javascript" src="{{ asset("public//vendor/lightbox/lightbox.min.js") }}"></script>

    <!-- MR Resize -->
    <script type="text/javascript" src="{{ asset("public//vendor/mrresize/mresize.min.js") }}"></script>


    <script type="text/javascript">
        var baseURL = "{{ url(App::getLocale()) }}";
        var csrfToken = "{{ csrf_token() }}";
        var isRTL = parseInt("{{ isRTL() }}");



        var getLocal = "{{ App::getLocale() }}";

        var commentsPage = 1;

        var articleCommentsTable = null;
        var manageLangsTable = null;
        var manageUsersTable = null;

        var month_1 = "{{ trans('ocv.month_1') }}";
        var month_2 = "{{ trans('ocv.month_2') }}";
        var month_3 = "{{ trans('ocv.month_3') }}";
        var month_4 = "{{ trans('ocv.month_4') }}";
        var month_5 = "{{ trans('ocv.month_5') }}";
        var month_6 = "{{ trans('ocv.month_6') }}";
        var month_7 = "{{ trans('ocv.month_7') }}";
        var month_8 = "{{ trans('ocv.month_8') }}";
        var month_9 = "{{ trans('ocv.month_9') }}";
        var month_10 = "{{ trans('ocv.month_10') }}";
        var month_11 = "{{ trans('ocv.month_11') }}";
        var month_12 = "{{ trans('ocv.month_12') }}";

        var month_now = "{{ trans('ocv.now') }}";

        var unknown_error = "{{ trans('ocv.msg_unknown_error') }}";
        var unknown_error_2 = '{!! trans('ocv.msg_unknown_error_2') !!}';
        var unknown_error_3 = "{{ trans('ocv.msg_unknown_error_3') }}";

        var msgDisableArticle = "{!! trans('ocv.msg_disable_article') !!}";
        var msgEnableArticle = "{!! trans('ocv.msg_enable_article') !!}";
        var msgDeleteArticle = "{!! trans('ocv.msg_delete_article') !!}";
        var msgDeleteComment = "{!! trans('ocv.msg_delete_comment') !!}";
        var btnClose = "{{ trans('ocv.close') }}";
        var btnNo = "{{ trans('ocv.no') }}";


        var dt_empty = "{{ trans('ocv.dt_empty') }}";
        var dt_info = "{{ trans('ocv.dt_info') }}";
        var dt_info_empty = "{{ trans('ocv.dt_info_empty') }}";
        var dt_filter = "{{ trans('ocv.dt_filter') }}";
        var dt_menu_record = "{{ trans('ocv.dt_menu_record') }}";
        var dt_loading = "{{ trans('ocv.dt_loading') }}";
        var dt_processing = "{{ trans('ocv.dt_processing') }}";
        var dt_search = "{{ trans('ocv.dt_search') }}";
        var dt_zero_record = "{{ trans('ocv.dt_zero_record') }}";
        var dt_first = "{{ trans('ocv.dt_first') }}";
        var dt_last = "{{ trans('ocv.dt_last') }}";
        var dt_next = "{{ trans('ocv.dt_next') }}";
        var dt_prev = "{{ trans('ocv.dt_prev') }}";
        var dt_sort_asc = "{{ trans('ocv.dt_sort_asc') }}";
        var dt_sort_desc = "{{ trans('ocv.dt_sort_desc') }}";

        var txt_approved = "{{ trans('ocv.approved') }}";
        var txt_not_approved = "{{ trans('ocv.not_approved') }}";

        var txt_enable = "{{trans('ocv.enable')}}";
        var txt_disable = "{{trans('ocv.disable')}}";

        var txt_as_admin = "{{trans('ocv.define_as_admin')}}";
        var txt_as_user = "{{trans('ocv.define_as_user')}}";

        var txt_active = "{{trans('ocv.active')}}";
        var txt_inactive = "{{trans('ocv.inactive')}}";

        var txt_hide = "{{ trans('ocv.hide') }}";
        var txt_approve = "{{ trans('ocv.approve') }}";

        var $kbGrid = $('#blog-items').masonry({
            // options
            itemSelector: '.blog-item'
            @if(isRTL())
            ,isRTL: true,
            originLeft: false
            @endif
        });

        var notifyPosition = '@if(isRTL()) bottom left @else bottom right @endif';



        @if(\App\User::isAdmin())

        $('#is_present').iCheck({
            checkboxClass: 'icheckbox_square-orange',
            radioClass: 'iradio_square-orange'
        });

        $("#from_month").select2({

        });
        $("#to_month").select2({

        });

        $('#edit-is_present').iCheck({
            checkboxClass: 'icheckbox_square-orange',
            radioClass: 'iradio_square-orange'
        });

        $("#edit-from_month").select2({

        });
        $("#edit-to_month").select2({

        });



        $("#color").select2({

        });
        $("#edit-color").select2({

        });





        $('#edu-is_present').iCheck({
            checkboxClass: 'icheckbox_square-orange',
            radioClass: 'iradio_square-orange'
        });

        $("#edu-from_month").select2({

        });
        $("#edu-to_month").select2({

        });

        $('#edit-edu-is_present').iCheck({
            checkboxClass: 'icheckbox_square-orange',
            radioClass: 'iradio_square-orange'
        });

        $("#edit-edu-from_month").select2({

        });
        $("#edit-edu-to_month").select2({

        });



        $("#article-cat").select2({

        });

        $('#article-enabled').iCheck({
            checkboxClass: 'icheckbox_square-orange',
            radioClass: 'iradio_square-orange'
        });

        $('#article-edit-enabled').iCheck({
            checkboxClass: 'icheckbox_square-orange',
            radioClass: 'iradio_square-orange'
        });




        var tags = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('id'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '{!!url("/")!!}' + '/tags/get?query=%QUERY%',
                wildcard: '%QUERY%',
            }
        });
        tags.initialize();

        $('#article-tags').tagsinput({
            confirmKeys: [13, 44],

            trimValue: true,
            allowDuplicates : false,
            freeInput: true,
            onTagExists: function(item, $tag) {
                $tag.hide().fadeIn();
            },
            typeaheadjs: [
                {
                    hint: false,
                    highlight: true,
                    minLength: 1
                },
                {
                    name: 'tags',
                    source: tags.ttAdapter(),
                    templates: {
                        empty: [
                            '<ul class="list-group" style="width:150px"><li class="list-group-item">{!! trans('ocv.msg_enter_to_add')  !!}</li></ul>'
                        ],
                        header: [
                            '<ul class="list-group" style="margin: 0">'
                        ],
                        suggestion: function (data) {
                            return '<li class="list-group-item">' + data + '</li>'
                        }
                    }
                }
            ]
        });


        $('#article-edit-tags').tagsinput({
            confirmKeys: [13, 44],

            trimValue: true,
            allowDuplicates : false,
            freeInput: true,
            onTagExists: function(item, $tag) {
                $tag.hide().fadeIn();
            },
            typeaheadjs: [
                {
                    hint: false,
                    highlight: true,
                    minLength: 1
                },
                {
                    name: 'tags',
                    source: tags.ttAdapter(),
                    templates: {
                        empty: [
                            '<ul class="list-group" style="width:150px"><li class="list-group-item">{!! trans('ocv.msg_enter_to_add')  !!}</li></ul>'
                        ],
                        header: [
                            '<ul class="list-group" style="margin: 0">'
                        ],
                        suggestion: function (data) {
                            return '<li class="list-group-item">' + data + '</li>'
                        }
                    }
                }
            ]
        });
        @endif

    </script>

    <script type="text/javascript">
        $(window).scroll(function() { //detect page scroll
            if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
                commentsPage++;
                loadMoreCommentsOnPageScroll(commentsPage);
            }
        });

        

        $(window).on('load', function() {
            $kbGrid.masonry();
        });



    </script>


@endsection





