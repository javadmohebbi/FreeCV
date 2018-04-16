<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">


    @foreach(getAllLanguages() as $lang)
    <url>
        <loc>{{ url($lang->short  . '/') }} </loc>
    </url>
    @endforeach


    @if ($arr[0]['total'] > 0)
        @foreach($arr[0]['kbs'] as $index => $article)
            <url>
                <loc>{{ url(getLangShortById($article->language_id) . '/blog/' . $article->slug) }} </loc>
                <lastmod>{{ $article->updated_at->format('Y-m-d') }}</lastmod>
            </url>
        @endforeach
    @endif


    @if ($arr[1]['total'] > 0)
        @foreach(getAllLanguages() as $lang)
            @foreach($arr[1]['tags'] as $index => $tag)
                <url>
                    <loc>{{ url($lang->short . '/hashtag/' . $tag->tag) }} </loc>
                </url>
            @endforeach
        @endforeach
    @endif

</urlset>