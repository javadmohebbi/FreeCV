<section class="content" id="blogs" style="">
    <h1 id="kb">
        <i class="fa fa-hashtag"></i>
        {{ trans('ocv.tag') }}
        : {{ $dataPassed['tag'] }}
    </h1>


    <div class="row resizable" style="" id="blog-items">

        @if (count($dataPassed['kbs']->toArray()) > 0)
            @foreach($dataPassed['kbs'] as $index => $article)
                <div class="col-sm-12 col-md-6 col-lg-4 blog-item" id="article-{{$article->id}}" data-kb-id="{{ $article->id }}">
                    <div class="item" style="background:white">
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

                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="text-center">
                {{ $dataPassed['kbs']->render() }}
            </div>
        </div>
    </div>


</section>