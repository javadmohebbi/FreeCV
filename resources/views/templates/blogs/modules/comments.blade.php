<section class="content img-rounded" id="kb-comments" style="background: #f8f8f8;overflow: hidden">
    <h3 style="margin: 5px;font-size: 20px">
        <i class="fa fa-comments"></i>
        {{ trans('ocv.comments') }}
    </h3>

    <div class="row img-rounded" style="background-color: #eeeeee; margin: 20px;padding: 20px">
        <div id="insert-comment" class="form">
            <div class="col-sm-12 col-md-4" style="margin-bottom: 20px">
                @if (!Auth::check())
                    {{ Auth::check() }}
                    <label>
                        {{ trans('ocv.name') }}
                    </label>
                    {{ Form::text('comment-name',null,
                                       array('class' => 'form-control',
                                            'maxlength' => 50,
                                            'placeholder' => trans('ocv.name'),
                                            'size' => 50,
                                            'id' => "comment-name",
                                       )
                           )
                    }}
                @else
                    <label class="label label-info">
                        <i class="fa fa-user"></i>
                        {{ getUsername() }}
                    </label>

                @endif
            </div>
            <div class="col-sm-12 col-md-5" style="margin-bottom: 20px">
                @if (!Auth::check())
                    <label>
                        {{ trans('ocv.email') }}
                    </label>
                    {{ Form::text('comment-email',null,
                                       array('class' => 'form-control ltr',
                                            'maxlength' => 255,
                                            'placeholder' => trans('ocv.example_email'),
                                            'size' => 255,
                                            'id' => "comment-email",
                                       )
                           )
                    }}
                @endif
            </div>
            <div class="col-sm-12" style="margin-bottom: 20px">
                <label>
                    {{ trans('ocv.comment') }}:
                </label>
                {{ Form::text('comment-comment',null,
                                   array('class' => 'form-control',
                                        'maxlength' => 255,
                                        'placeholder' => trans('ocv.comment'),
                                        'size' => 255,
                                        'id' => "comment-comment",
                                   )
                       )
                }}
            </div>
            <div class="col-sm-12" >
                <a href="javascript:void(0);" id="btn-save-comment"
                   data-id="{{ $article->id }}"
                   class="btn btn-success">
                    {{ trans('ocv.send_comment') }}
                </a>
                <img id="comment-insert-loading" class="loading hidden" src="{{ asset('public/img/ajax-loader.gif') }}" alt="loading"/>
            </div>
            <div class="col-sm-12" style="margin-bottom: 20px;margin-top: 10px">
                <div id="btn-save-comment-stat"
                     class="hidden">

                </div>
            </div>

        </div>
    </div>

    <div class="row blog-comments">
        <div id="comments-container">
        @if (count(getApprovedComments($article->id)))
            @foreach(getApprovedComments($article->id) as $index => $comment)
                <div class="col-sm-12 blog-comment @if($index%2==0) odd @endif"
                     style="padding: 15px" data-id="{{ $comment->id }}">
                    <div class="col-sm-12 @if (isRTL()) text-right @endif" data-id="{{ $comment->id }}">
                        <label class="label label-default @if (isRTL()) rtl @endif">
                            <i class="fa fa-calendar-o"></i>
                            {{ getHumanReadableDateTime($comment->created_at) }}
                        </label>
                        <label class="label label-info @if (isRTL()) rtl @endif" style="margin: 5px">
                            {{ getCommenterName($comment->id) }}
                        </label>
                    </div>
                    <div class="col-sm-12 comments" data-id="{{ $comment->id }}">
                        <i class="fa fa-comment"></i>
                        {{ $comment->comments }}
                    </div>
                 </div>
            @endforeach
        @endif
        </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="commentLoading" class="hidden" style="text-align: center">
                        <img id="commentLoading-img" class="loading" src="{{ asset('public/img/ajax-loader.gif') }}" alt="loading"/>
                        <span class="text-info">
                    {{ trans('ocv.loading') }}
                </span>
                        <span class="error hidden">
                    <span class="text-danger">
                        {{ trans('ocv.msg_can_not_load_more_data') }}
                    </span>
                    <a href="javascript:void(0);" id="btnCommentLoadTryAgain">
                        {{ trans('ocv.try_again') }}
                    </a>
                </span>
                    </div>
                </div>
            </div>
    </div>

</section>


