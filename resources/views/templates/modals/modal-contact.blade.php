<div id="modalEditContacts" class="modal fade" >

    <div class="modal-dialog" style="overflow-y: initial !important; width: 99%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    {{ trans('ocv.edit') }}
                    |
                    {{ trans('ocv.contact_me') }}
                </h4>
            </div>

            <div class="modal-body" style="max-height: 100%;overflow-y: auto;width: 100%;">
                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.tell') }}
                    </label>

                    {{ Form::text('tell',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 50,
                                        'placeholder' => trans('ocv.example_tell'),
                                        'style' => 'direction:ltr; text-align:left',
                                        'size' => 30,
                                        'id' => "tell",
                                   )
                       )
                    }}
                </div>

                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.email') }}
                    </label>

                    {{ Form::text('email',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 255,
                                        'placeholder' => trans('ocv.example_email'),
                                        'style' => 'direction:ltr; text-align:left',
                                        'size' => 60,
                                        'id' => "email",
                                   )
                       )
                    }}
                </div>

                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.facebook') }}
                    </label>

                    {{ Form::text('fb',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 255,
                                        'placeholder' => trans('ocv.example_social_url'),
                                        'style' => 'direction:ltr; text-align:left',
                                        'size' => 60,
                                        'id' => "fb",
                                   )
                       )
                    }}
                </div>

                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.twitter') }}
                    </label>

                    {{ Form::text('tw',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 255,
                                        'placeholder' => trans('ocv.example_social_url'),
                                        'style' => 'direction:ltr; text-align:left',
                                        'size' => 60,
                                        'id' => "tw",
                                   )
                       )
                    }}
                </div>


                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.youtube') }}
                    </label>

                    {{ Form::text('ytt',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 255,
                                        'placeholder' => trans('ocv.example_social_url'),
                                        'style' => 'direction:ltr; text-align:left',
                                        'size' => 60,
                                        'id' => "ytt",
                                   )
                       )
                    }}
                </div>

                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.instagram') }}
                    </label>

                    {{ Form::text('ig',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 255,
                                        'placeholder' => trans('ocv.example_social_url'),
                                        'style' => 'direction:ltr; text-align:left',
                                        'size' => 60,
                                        'id' => "ig",
                                   )
                       )
                    }}
                </div>

                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.linkedin') }}
                    </label>

                    {{ Form::text('li',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 255,
                                        'placeholder' => trans('ocv.example_social_url'),
                                        'style' => 'direction:ltr; text-align:left',
                                        'size' => 60,
                                        'id' => "li",
                                   )
                       )
                    }}
                </div>

                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.github') }}
                    </label>

                    {{ Form::text('gh',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 255,
                                        'placeholder' => trans('ocv.example_social_url'),
                                        'style' => 'direction:ltr; text-align:left',
                                        'size' => 60,
                                        'id' => "gh",
                                   )
                       )
                    }}
                </div>

                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.telegram') }}
                    </label>

                    {{ Form::text('tg',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 255,
                                        'placeholder' => trans('ocv.example_social_url'),
                                        'style' => 'direction:ltr; text-align:left',
                                        'size' => 60,
                                        'id' => "tg",
                                   )
                       )
                    }}
                </div>


                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.googleplus') }}
                    </label>

                    {{ Form::text('gp',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 255,
                                        'placeholder' => trans('ocv.example_social_url'),
                                        'style' => 'direction:ltr; text-align:left',
                                        'size' => 60,
                                        'id' => "gp",
                                   )
                       )
                    }}
                </div>

                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.pinterest') }}
                    </label>

                    {{ Form::text('pi',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 255,
                                        'placeholder' => trans('ocv.example_social_url'),
                                        'style' => 'direction:ltr; text-align:left',
                                        'size' => 60,
                                        'id' => "pi",
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

                <button id="btnSaveContacts" type="button" class="submit btn btn-primary">
                    {{ trans('ocv.save') }}
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    {{ trans('ocv.close')  }}
                </button>
            </div>
        </div>
    </div>
</div>





