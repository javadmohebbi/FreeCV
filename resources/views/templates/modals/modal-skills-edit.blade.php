<div id="modalEditSkills" class="modal fade" >

    <div class="modal-dialog" style="overflow-y: initial !important; width: 99%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    {{ trans('ocv.edit') }}
                    |
                    {{ trans('ocv.skills') }}
                </h4>
            </div>

            <div class="modal-body" style="overflow-y: auto;width: 100%;">
                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.skill') }}
                    </label>
                    {{ Form::text('edit-skill',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 50,
                                        'placeholder' => trans('ocv.example_skill_name'),
                                        'size' => 50,
                                        'id' => "edit-skill",
                                   )
                       )
                    }}
                </div>
                <div class="col-sm-12 form-group form-inline">
                        <label class="@if(isRTL()) pull-right @else pull-left @endif">
                            {{ trans('ocv.color') }}
                        </label>

                        <select id="edit-color" name="edit-color"
                                class="form-control col-sm-12">
                            <option value="1">{{trans('ocv.color_skill_1')}}</option>
                            <option value="2">{{trans('ocv.color_skill_2')}}</option>
                            <option value="3">{{trans('ocv.color_skill_3')}}</option>
                            <option value="4">{{trans('ocv.color_skill_4')}}</option>
                            <option value="5">{{trans('ocv.color_skill_5')}}</option>
                        </select>
                </div>


                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.percentage') }}
                    </label>

                    {{ Form::text('edit-percentage',null,
                                   array('class' => 'form-control text-center',
                                        'maxlength' => 3,
                                        'placeholder' => trans('ocv.example_percentage'),
                                        'size' => 3,
                                        'id' => "edit-percentage",
                                        'style' => 'direction:ltr'
                                   )
                       )
                    }}
                </div>


            </div>


            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-12 form-group ">
                        <div class="error alert alert-danger hidden">
                            <strong>
                                {!! trans('ocv.sorry') !!}
                            </strong>
                            <ul style="list-style: none">

                            </ul>
                        </div>
                    </div>
                </div>

                <img class="loading hidden" src="{{ asset('public/img/ajax-loader.gif') }}" alt="loading"/>

                <button id="btnEditSkill" type="button" class="submit btn btn-primary">
                    {{ trans('ocv.save') }}
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    {{ trans('ocv.close')  }}
                </button>
            </div>
        </div>
    </div>
</div>





