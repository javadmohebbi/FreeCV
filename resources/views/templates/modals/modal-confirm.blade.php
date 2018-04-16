<div id="modalConfirm" class="modal fade" >

    <div class="modal-dialog" style="overflow-y: initial !important; width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    {{ trans('ocv.confirm') }}
                </h4>
            </div>

            <div class="modal-body" style="overflow-y: auto;width: 100%;">
                <div class="col-sm-12 modal-desc">
                    Description
                </div>
            </div>


            <div class="modal-footer">
                <img class="loading hidden" src="{{ asset('public/img/ajax-loader.gif') }}" alt="loading"/>
                <button id="btnYes" type="button" class="submit btn btn-primary">
                    {{ trans('ocv.yes') }}
                </button>
                <button id="btnNo" type="button" class="btn btn-danger" data-dismiss="modal">
                    {{ trans('ocv.no')  }}
                </button>
            </div>
        </div>
    </div>
</div>





