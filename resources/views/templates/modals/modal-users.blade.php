<div id="modalUsers" class="modal fade" style="z-index:9999999999" >

    <div class="modal-dialog" style="overflow-y: initial !important; width: 99%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    {{ trans('ocv.manage_users') }}
                </h4>
            </div>

            <div class="modal-body" style="overflow-y: auto;width: 100%;">
                <div class="col-sm-12 modal-desc">
                    <div class="row" id="DivManageUsers">
                        <table id="usersTable" class="display nowrap dataTable dtr-inline"
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
                                    {{ trans('ocv.email') }}
                                </th>
                                <th tabindex="0"
                                    rowspan="1" colspan="1">
                                    {{ trans('ocv.status') }}
                                </th>
                                <th tabindex="0"
                                    rowspan="1" colspan="1">
                                    {{ trans('ocv.is_admin') }}
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


            <div class="modal-footer" id="user-modal-error">
                <div class="row">
                    <div class="col-sm-12 form-group ">
                        <div class="error alert alert-danger">
                            <strong>
                                {!! trans('ocv.sorry') !!}
                            </strong>
                            <ul class="ul-error" style="list-style: none">

                            </ul>
                        </div>
                    </div>
                </div>
                <img class="loading hidden" src="{{ asset('public/img/ajax-loader.gif') }}" alt="loading"/>
                <button type="button"  class="btn btn-default" data-dismiss="modal">
                    {{ trans('ocv.close')  }}
                </button>
            </div>
        </div>
    </div>
</div>





