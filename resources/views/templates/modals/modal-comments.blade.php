<div id="modalComments" class="modal fade" style="z-index:9999999999" >

    <div class="modal-dialog" style="overflow-y: initial !important; width: 99%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    {{ trans('ocv.comments') }} | {{ trans('ocv.kb') }}
                </h4>
            </div>

            <div class="modal-body" style="overflow-y: auto;width: 100%;">
                <div class="col-sm-12 modal-desc">
                    <div class="row" id="articleComments" style="overflow-x: auto;">
                            <table id="articleCommentsTable" class="display dataTable dtr-inline"
                                   style="width: 100%" cellspacing="0" width="100%"
                                   role="grid">
                                <thead>
                                <tr role="row">
                                    <th tabindex="0"
                                        rowspan="1" colspan="1">
                                        {{ trans('ocv.date') }}
                                    </th>
                                    <th tabindex="0"
                                        rowspan="1" colspan="1">
                                        {{ trans('ocv.name') }}
                                    </th>
                                    <th tabindex="0"
                                        rowspan="1" colspan="1">
                                        {{ trans('ocv.email') }}
                                    </th>
                                    <th tabindex="0"
                                        rowspan="1" colspan="1">
                                        {{ trans('ocv.comment') }}
                                    </th>
                                    <th tabindex="0"
                                        rowspan="1" colspan="1">
                                        {{ trans('ocv.status') }}
                                    </th>
                                    <th tabindex="0" rowspan="1" colspan="1">
                                        {{ trans('ocv.operation') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>


            <div class="modal-footer">
                <img class="loading hidden" src="{{ asset('public/img/ajax-loader.gif') }}" alt="loading"/>
                <button type="button"  class="btn btn-default" data-dismiss="modal">
                    {{ trans('ocv.close')  }}
                </button>
            </div>
        </div>
    </div>
</div>





