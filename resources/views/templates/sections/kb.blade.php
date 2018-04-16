<section class="content" id="blogs" style="background: white">
    <h1 id="kb">
        <i class="fa fa-newspaper-o"></i>
        {{ trans('ocv.kb') }}

        @if(checkIfAdmin())
            <a id="btnAddNewKB"
               href="javascript:void(0);"
               class="btn btn-danger"/>
            <i class="fa fa-plus"></i>
            {{ trans('ocv.add') }}
            </a>
            <img class="article-loading hidden" src="{{ asset('public/img/ajax-loader.gif') }}" alt="loading"/>
            <!--<input id="isKbEnabled"  checked data-toggle="toggle" data-size="normal" type="checkbox">-->
        @endif
    </h1>


    <div class="row resizable" style="" id="blog-items">

        @if (count(getBlogs()->toArray()) > 0)
            @foreach(getBlogs() as $index => $article)
            <div class="col-sm-12 col-md-6 col-lg-4 blog-item" id="article-{{$article->id}}" data-kb-id="{{ $article->id }}">
            <div class="item">
                <div class="article-img">
                    <a href="{{ url(App::getLocale() . '/blog/' . $article->slug) }}" title="{{ $article->title }}">
                        <img src="{{ getBlogImage($article->image_id) }}" class="img-responsive" alt="" />
                    </a>
                </div>
                <h2>
                    <a href="{{ url(App::getLocale() . '/blog/' . $article->slug) }}" title="{{ $article->title }}">
                        <i class="fa fa-newspaper-o"></i>
                        {{ $article->title }}
                    </a>
                </h2>
                <ul class="list-inline article-date-time">
                    <li class="time"><i class="fa fa-calendar"></i>{{ getBlogDate($article->created_at) }}</li>
                    <li><i class="fa fa-comments"></i>{{ getBlogCommentCounts($article->id) }}</li>
                    <li><i class="fa fa-eye"></i>{{ getBlogViewCount($article->id) }}</li>
                </ul>
                <p class="article-body">
                    {{ $article->summary }}
                    <a href="{{ url(App::getLocale() . '/blog/' . $article->slug) }}" title="{{ $article->title }}">
                        {{ trans('ocv.kb_read_more') }}
                    </a>
                </p>




                <div class="article-tags">
                    @if (count(getBlogTags($article->id)) > 0 )
                    <ul class="list-inline">
                        @foreach(getBlogTags($article->id) as $tag)
                        <li>
                            <a href="{{ url(App::getLocale() . '/hashtag/' . $tag->tag ) }}" title=" {{ $tag->tag }}">
                                <i class="fa fa-hashtag"></i>
                                {{ $tag->tag }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>

                @if(checkIfAdmin())
                <div class="article-btn text-center">
                    <a class="btn btn-success btn-img-article" href="javascript:void(0);" data-id="{{ $article->id }}">
                        <i class="fa fa-image"></i>
                    </a>
                    <a class="btn btn-info btn-edit-article" href="javascript:void(0);" data-id="{{ $article->id }}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a class="btn btn-primary btn-comment-article" href="javascript:void(0);" data-id="{{ $article->id }}">
                        <i class="fa fa-comments"></i>
                    </a>
                    @if($article->enabled == 1)
                        <a class="btn btn-warning btn-enabled-article" href="javascript:void(0);" data-enabled="1" data-id="{{ $article->id }}">
                            <i class="fa fa-eye-slash"></i>
                        </a>
                    @else
                        <a class="btn btn-warning btn-enabled-article" href="javascript:void(0);" data-enabled="2" data-id="{{ $article->id }}">
                            <i class="fa fa-eye"></i>
                        </a>
                    @endif
                    <a class="btn btn-danger btn-delete-article" href="javascript:void(0);" data-id="{{ $article->id }}">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
            @endforeach
        @endif
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div id="kbLoading" class="" style="text-align: center">
                <img id="kbLoading" class="loading" src="{{ asset('public/img/ajax-loader.gif') }}" alt="loading"/>
                <span class="text-info">
                    {{ trans('ocv.loading') }}
                </span>
                <span class="error hidden">
                    <span class="text-danger">
                        {{ trans('ocv.msg_can_not_load_more_data') }}
                    </span>
                    <a href="javascript:void(0);" id="btnArticleTryAgain">
                        {{ trans('ocv.try_again') }}
                    </a>
                </span>
            </div>
        </div>
    </div>




</section>



<!-- Add New Article Modal -->
@include('templates.modals.modal-article-add')


<!-- Edit Article Modal -->
@include('templates.modals.modal-article-edit')


<!-- Edit Article Image Modal -->
@include('templates.modals.modal-article-image')

<!-- Confirm Dialog -->
@include('templates.modals.modal-confirm')


<!-- Comment Modal -->
@include('templates.modals.modal-comments')





