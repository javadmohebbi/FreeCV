<div id="modalEditEdu" class="modal fade" >

    <div class="modal-dialog" style="overflow-y: initial !important; width: 99%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    {{ trans('ocv.edit') }}
                    |
                    {{ trans('ocv.experiences_and_education') }}
                </h4>
            </div>

            <div class="modal-body" style="overflow-y: auto;width: 100%;">
                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.name') }}
                    </label>

                    {{ Form::text('edit-edu-name',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 50,
                                        'placeholder' => trans('ocv.example_edu_name'),
                                        'size' => 50,
                                        'id' => "edit-edu-name",
                                   )
                       )
                    }}
                </div>
                <div class="col-sm-12 form-group form-inline">

                    <select id="edit-edu-from_month" name="edit-edu-from_month"
                            class="form-control col-sm-12">
                        <option value="1">{{trans('ocv.month_1')}}</option>
                        <option value="2">{{trans('ocv.month_2')}}</option>
                        <option value="3">{{trans('ocv.month_3')}}</option>
                        <option value="4">{{trans('ocv.month_4')}}</option>
                        <option value="5">{{trans('ocv.month_5')}}</option>
                        <option value="6">{{trans('ocv.month_6')}}</option>
                        <option value="7">{{trans('ocv.month_7')}}</option>
                        <option value="8">{{trans('ocv.month_8')}}</option>
                        <option value="9">{{trans('ocv.month_9')}}</option>
                        <option value="10">{{trans('ocv.month_10')}}</option>
                        <option value="11">{{trans('ocv.month_11')}}</option>
                        <option value="12">{{trans('ocv.month_12')}}</option>
                    </select>
                    <label>
                        {{ trans('ocv.from_year') }}
                    </label>
                    {{ Form::text('edit-edu-from_year',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 4,
                                        'placeholder' => trans('ocv.example_project_from_year'),
                                        'size' => 4,
                                        'id' => "edit-edu-from_year",
                                   )
                       )
                    }}
                </div>

                <div class="col-sm-12 form-group form-inline">

                    <select id="edit-edu-to_month" name="edit-edu-to_month"
                            class="form-control col-sm-12">
                        <option value="1">{{trans('ocv.month_1')}}</option>
                        <option value="2">{{trans('ocv.month_2')}}</option>
                        <option value="3">{{trans('ocv.month_3')}}</option>
                        <option value="4">{{trans('ocv.month_4')}}</option>
                        <option value="5">{{trans('ocv.month_5')}}</option>
                        <option value="6">{{trans('ocv.month_6')}}</option>
                        <option value="7">{{trans('ocv.month_7')}}</option>
                        <option value="8">{{trans('ocv.month_8')}}</option>
                        <option value="9">{{trans('ocv.month_9')}}</option>
                        <option value="10">{{trans('ocv.month_10')}}</option>
                        <option value="11">{{trans('ocv.month_11')}}</option>
                        <option value="12">{{trans('ocv.month_12')}}</option>
                    </select>
                    <label>
                        {{ trans('ocv.to_year') }}
                    </label>
                    {{ Form::text('edit-edu-to_year',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 4,
                                        'placeholder' => trans('ocv.example_project_to_year'),
                                        'size' => 4,
                                        'id' => "edit-edu-to_year",
                                   )
                       )
                    }}
                    <label style="cursor: pointer">
                        <input type="checkbox" data-checked="null" class="form-control" id="edit-edu-is_present" name="edit-edu-is_present" value=""/>
                        {{ trans('ocv.is_present') }}
                    </label>
                </div>
                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.link') }}
                    </label>

                    {{ Form::text('edit-edu-link',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 255,
                                        'placeholder' => trans('ocv.example_edu_link'),
                                        'size' => 80,
                                        'id' => "edit-edu-link",
                                   )
                       )
                    }}
                </div>


                <div class="col-sm-12 form-group">
                    <label>
                        {{ trans('ocv.description') }}
                    </label>
                    {{ Form::textarea('edit-edu-proj-description',null,
                                   array('class' => 'summernote',
                                        'id' => "edit-edu-proj-description",

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

                <button id="btnEditEdu" type="button" class="submit btn btn-primary">
                    {{ trans('ocv.save') }}
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    {{ trans('ocv.close')  }}
                </button>
            </div>
        </div>
    </div>
</div>





