<section id="blogSection-{{$article->id}}" class="content" style="min-height: 320px">


    <div class="img-rounded blog-summary" style="background: white;overflow: hidden;margin: 0;padding: 0">
        @if (isset($article->image_id))
            <div class="summary-image @if (isRTL()) pull-left @else pull-right @endif"
                 style="background-image: url('{{getBlogImage($article->image_id)}}')"

            >

                <a href="{{ getBlogImage($article->image_id) }}" data-lightbox="datalightbox-article" title="{{$article->title}}" >
                    <img id="" class="summary-image-alpha img-responsive"
                         alt="{{ $article->title }}"
                         src="{{ getBlogImage($article->image_id) }}"
                    >
                </a>
            </div>
        @endif


        <h1 style="margin: 5px;font-size: 25px">
            <i class="fa fa-newspaper-o"></i>
            {{ $article->title }}
        </h1>
        <ul class="list-inline article-date-time;" style="margin: 1px;">
            <li class="time"><i class="fa fa-calendar"></i>&nbsp;{{ getBlogDate($article->created_at) }}</li>
            <li><i class="fa fa-comments"></i>&nbsp;{{ getBlogCommentCounts($article->id) }}</li>
            <li><i class="fa fa-eye"></i>&nbsp;{{ getBlogViewCount($article->id) }}</li>
        </ul>

        <p class="article-body" style="margin: 5px;">
            {{ $article->summary }}
        </p>

            @if (count(getBlogTags($article->id)) > 0 )
                <ul class="list-inline" style="margin: 5px;">
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

    <div style="margin: 20px auto">
       {!! $article->html_desc  !!}
    </div>

    @include('templates.blogs.modules.comments')

</section>