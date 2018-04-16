<div id="modalAddArticle" class="modal fade" >

    <div class="modal-dialog" style="overflow-y: initial !important; width: 99%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    {{ trans('ocv.add') }}
                    |
                    {{ trans('ocv.kb') }}
                </h4>
            </div>

            <div class="modal-body" style="overflow-y: auto;width: 100%;">

                <div class="col-sm-12 form-group form-inline">
                    <label style="cursor: pointer">
                        <input type="checkbox" data-checked="null" class="form-control" id="article-enabled" name="article-enabled" value=""/>
                        {{ trans('ocv.enable') }}
                    </label>
                </div>


                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.title') }}
                    </label>

                    {{ Form::text('article-title',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 100,
                                        'placeholder' => trans('ocv.example_article_title'),
                                        'size' => 50,

                                        'id' => "article-title",
                                   )
                       )
                    }}
                </div>

                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.slug') }}
                    </label>

                    {{ Form::text('article-slug',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 200,
                                        'placeholder' => trans('ocv.example_article_slug'),
                                        'size' => 50,
                                        'id' => "article-slug",
                                   )
                       )
                    }}
                </div>


                <!--<div class="col-sm-12 form-group">
                    <label>
                        {{ trans('ocv.category') }}
                    </label>

                    <select id="article-cat" style="min-width: 100px" name="article-cat"
                            class="form-control col-sm-12">
                        <option value="" selected="selected">{{ trans('ocv.msg_nothing_selected') }}</option>
                    </select>
                </div>-->


                <div class="col-sm-12 form-group form-inline">
                    <label>
                        {{ trans('ocv.summary') }}
                    </label>

                    {{ Form::text('article-summary',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 1000,
                                        'placeholder' => trans('ocv.example_article_summary'),
                                        'size' => 50,

                                        'id' => "article-summary",
                                   )
                       )
                    }}
                </div>


                <div class="col-sm-12 form-group">
                    {{ Form::label('article-tags', trans('ocv.tags'),
                                   array('class' => 'control-label')
                       )
                    }}
                    {{ Form::text('article-tags',null,
                                   array('class' => 'form-control',
                                   'id' => 'article-tags'
                                   )
                       )
                    }}
                </div>


                <div class="col-sm-12 form-group">
                    <label>
                        {{ trans('ocv.description') }}
                    </label>
                    {{ Form::textarea('article-desc',null,
                                   array('class' => 'summernote',
                                        'id' => "article-desc",

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

                <button id="btnSaveNewArticle" type="button" class="submit btn btn-primary">
                    {{ trans('ocv.save') }}
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    {{ trans('ocv.close')  }}
                </button>
            </div>
        </div>
    </div>
</div>





