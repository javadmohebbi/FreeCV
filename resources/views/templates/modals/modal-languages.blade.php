<div id="modalLanguages" class="modal fade" style="z-index:9999999999" >

    <div class="modal-dialog" style="overflow-y: initial !important; width: 99%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    {{ trans('ocv.language_management') }}
                </h4>
            </div>

            <div class="modal-body" style="overflow-y: auto;width: 100%;">
                <div class="col-sm-12 modal-desc">
                    <div class="row" id="Langs" style="overflow-x: auto;">
                        <table id="langsTable" class="display dataTable dtr-inline"
                               style="width: 100%" cellspacing="0" width="100%"
                               role="grid">
                            <thead>
                            <tr role="row">
                                <th tabindex="0"
                                    rowspan="1" colspan="1">
                                    {{ trans('ocv.name') }}
                                </th>
                                <th tabindex="0"
                                    rowspan="1" colspan="1">
                                    {{ trans('ocv.iso_639') }}
                                </th>
                                <th tabindex="0"
                                    rowspan="1" colspan="1">
                                    {{ trans('ocv.status') }}
                                </th>
                                <th tabindex="0"
                                    rowspan="1" colspan="1">
                                    {{ trans('ocv.direction') }}
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





