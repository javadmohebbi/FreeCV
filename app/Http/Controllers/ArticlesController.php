<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use App\Http\Requests\AddNewArticle;
use App\Http\Requests\UpdateArticle;
use App\Image;
use App\Setting;
use App\Tag;
use App\TagItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use App\Language;
use Illuminate\Support\Facades\Response;
use App\User;
use Morilog\Jalali\Facades\jDate;
use Morilog\Jalali\JalaliServiceProvider;

class ArticlesController extends Controller
{
    protected $article;
    protected $lang;

    function __construct(Article $article) {
        $this->article = $article;
        $this->lang = App::getLocale();
    }



    public function getArticle(Article $article){
        if (isset($article->id)) {

            $articleViewed = $article->viewed;
            $article->fill([
                'viewed' => ++$articleViewed]
            )->save();
            return view('templates.blogs.blog', compact('article'));
        } else {
            abort(404);
        }

    }



    /**
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function disableKbById(Article $article){
        if(User::isAdmin()) {
            $article->fill(['enabled' => 2])->save();
            return Response::json([
                'result' => true,
            ]);
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }

    /**
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function enableKbById(Article $article){
        if(User::isAdmin()) {
            $article->fill(['enabled' => 1])->save();
            return Response::json([
                'result' => true,
            ]);
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }

    /**
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteKbById(Article $article){
        if(User::isAdmin()) {
            $imageId = $article->image_id;
            $image = Image::select()->where('id', '=', $imageId)->first();

            $tagItems = TagItem::select()->where('article_id', '=', $article->id);
            $tagItems->delete();

            $comments = Comment::select()->where('article_id', '=', $article->id);
            $comments->delete();

            $article->delete();

            if ($image != null) {
                $image->delete();
                $fullPath = base_path() . '/public/img/articles/' . $image->path;
                if (is_writable($fullPath)){
                    unlink($fullPath);
                }
            }

            return Response::json([
                'result' => true,
            ]);
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }


    /**
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function getKbById(Article $article){
        if(User::isAdmin()) {
            $tags = new Tag();
            $tags = $tags->getTagsBelongsToBlog($article->id);
            $arrTags = [];
            foreach ($tags as $tag){
                array_push($arrTags, $tag->tag);
            }

            return Response::json([
                'id' => $article->id,
                'title' => $article->title,
                'slug' => $article->slug,
                'summary' => $article->summary,
                'enabled' => $article->enabled,
                'html_desc' => $article->html_desc,
                'tags' => $arrTags,
            ]);
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }


    /**
     * @param Article $article
     * @param UpdateArticle $request
     * @return \Illuminate\Http\JsonResponse
     */
    function updateKB(Article $article, UpdateArticle $request) {
        if(User::isAdmin()) {
            /* Delete Prev. Tag Items */
            $tag = new Tag();
            $tag->editTags($request->tags, $request->id);


            $dateTime = $article->created_at;

            $setting = new Setting();
            $returnDateTime = $setting->getHumanReadableDateTime($dateTime, App::getLocale());


            /* Update */
            $article->fill(
                [
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'html_desc' => $request->html_desc,
                    'enabled' => $request->enabled,
                    'summary' => $request->summary,
                    'user_id' => \Auth::user()->id,
                    'updated_at'    =>  Carbon::now()
                ]
            )->save();

            /* Insert Updated Tags */
            if ($request->tags != null) {
                $tag = New Tag();
                $tag->insertTags($request->tags, $request->id); // Add Tags to database
            }


            return Response::json([
                'id' => $request->id,
                'title' => $request->title,
                'slug' => $request->slug,
                'html_desc' => $request->html_desc,
                'enabled' => $request->enabled,
                'summary' => $request->summary,
                'user_id' => \Auth::user()->id,
                'defaultImage' => asset('public/img/default.jpg'),
                'date' => $returnDateTime,
                'readMore' => trans('ocv.kb_read_more'),
                'url' => url(App::getLocale() . '/blog/' . $request->slug),
                'baseURL' => url(App::getLocale()),
                'tags' => array_map('rtrim', explode(',', $request->tags)),
            ], 200);




        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }


    /**
     * @param AddNewArticle $request
     * @return \Illuminate\Http\JsonResponse
     */
    function addNewKB(AddNewArticle $request){
        if(User::isAdmin()) {
            $langId = Language::getLanguageId($this->lang);
            $dateTime = Carbon::now();

            $setting = new Setting();
            $returnDateTime = $setting->getHumanReadableDateTime($dateTime, App::getLocale());


            $id = $this->article->insertGetId([
                'title' => $request->title,
                'slug' => $request->slug,
                'html_desc' => $request->html_desc,
                'enabled' => $request->enabled,
                'summary' => $request->summary,
                'user_id' => \Auth::user()->id,
                'language_id' => $langId,
                'created_at'    =>  $dateTime,
                'updated_at'    =>  $dateTime
            ]); // Insert requested product to Products table

            if ($request->tags != null) {
                $tag = New Tag();
                $tag->insertTags($request->tags, $id); // Add Tags to database
            }


            return Response::json([
                'id' => $id,
                'title' => $request->title,
                'slug' => $request->slug,
                'html_desc' => $request->html_desc,
                'enabled' => $request->enabled,
                'summary' => $request->summary,
                'user_id' => \Auth::user()->id,
                'defaultImage' => asset('public/img/default.jpg'),
                'date' => $returnDateTime,
                'readMore' => trans('ocv.kb_read_more'),
                'url' => url(App::getLocale() . '/blog/' . $request->slug),
                'baseURL' => url(App::getLocale()),
                'tags' => array_map('rtrim', explode(',', $request->tags)),
            ], 200);

        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }


    /**
     * @param Request $request
     */
    function ajaxLoadMoreArticle(Request $request){
        $articles = new Article();
        $articles = $articles->getPaginate(App::getLocale());

        $len = (count($articles));
        $arrArticle = [];
        $arrArticleIds = [];
        foreach ($articles as $article) {
            $html = '';
            $imagePath = url('/img/default.jpg');
            if ($article->image_id != null) {
                $image = Image::select('path')
                    ->where('id', '=', $article->image_id)
                    ->first()->path;
                $imagePath = url('/img/articles/' . $image);
            }

            $articleViewCount = new Article();
            $articleViewCount = $articleViewCount->getArticleViewCount($article->id);

            $articleCommentCount = count(Comment::select()->where('article_id', '=', $article->id)->get());

            $articleDate = new Setting();
            $articleDate = $articleDate->getHumanReadableDateTime($article->created_at, App::getLocale());


            $tags = new Tag();
            $tags = $tags->getTagsBelongsToBlog($article->id);


            $html .= '<div class="col-sm-12 col-md-6 col-lg-4 blog-item" id="article-'.$article->id.'" data-kb-id="'.$article->id.'">';
            $html .= '  <div class="item">';
            $html .= '      <div class="article-img">';
            $html .= '          <a href="'.url(App::getLocale() . '/blog/' . $article->slug).'" title="'.$article->title .'">';
            $html .= '              <img src="'.$imagePath.'" class="img-responsive" alt="" />';
            $html .= '          </a>';
            $html .= '      </div>';
            $html .= '      <h2>';
            $html .= '          <a href="'.url(App::getLocale() . '/blog/' . $article->slug).'" title="'. $article->title .'">';
            $html .= '               <i class="fa fa-newspaper-o"></i>&nbsp;';
            $html .= '               '.$article->title;
            $html .= '          </a>';
            $html .= '      </h2>';
            $html .= '      <ul class="list-inline article-date-time">';
            $html .= '          <li class="time"><i class="fa fa-calendar"></i>'.  $articleDate .'</li>';
            $html .= '          <li><i class="fa fa-comments"></i>'. $articleCommentCount .'</li>';
            $html .= '          <li><i class="fa fa-eye"></i>'. $articleViewCount .'</li>';
            $html .= '      </ul>';
            $html .= '      <p class="article-body">';
            $html .= '          ' . $article->summary;
            $html .= '          <a href="'.url(App::getLocale() . '/blog/' . $article->slug).'" title="'.$article->title .'">';
            $html .= '              ' . trans('ocv.kb_read_more');
            $html .= '          </a>';
            $html .= '      </p>';
            $html .= '      <div class="article-tags">';
            if (count($tags)) {
                $html .= '      <ul class="list-inline">';
                foreach ($tags as $tag) {
                    $html .= '          <li>';
                    $html .= '                  <a href="'. url(App::getLocale() . '/hashtag/' . $tag->tag ) .'" title="'.$tag->tag.'">';
                    $html .= '                      <i class="fa fa-hashtag"></i>';
                    $html .= '                      '.$tag->tag;
                    $html .= '                  </a>';
                    $html .= '           </li>';
                }
            }
            $html .= '          </ul>';
            $html .= '       </div>';
            if (User::isAdmin()){
                $html .= '      <div class="article-btn text-center">';
                $html .= '          <a class="btn btn-success btn-img-article" href="javascript:void(0);" data-id="'.$article->id.'">';
                $html .= '              <i class="fa fa-image"></i>';
                $html .= '          </a>';
                $html .= '          <a class="btn btn-info btn-edit-article" href="javascript:void(0);" data-id="'.$article->id.'">';
                $html .= '              <i class="fa fa-edit"></i>';
                $html .= '          </a>';
                $html .= '          <a class="btn btn-primary btn-comment-article" href="javascript:void(0);" data-id="'.$article->id.'">';
                $html .= '              <i class="fa fa-comments"></i>';
                $html .= '          </a>';
                if ($article->enabled == 1) {
                    $html .= '          <a class="btn btn-warning btn-enabled-article" href="javascript:void(0);" data-enabled="1" data-id="' . $article->id . '">';
                    $html .= '              <i class="fa fa-eye-slash"></i>';
                    $html .= '          </a>';
                } else {
                    $html .= '          <a class="btn btn-warning btn-enabled-article" href="javascript:void(0);" data-enabled="2" data-id="'.$article->id.'">';
                    $html .= '              <i class="fa fa-eye"></i>';
                    $html .= '          </a>';
                }
                $html .= '          <a class="btn btn-danger btn-delete-article" href="javascript:void(0);" data-id="'.$article->id.'">';
                $html .= '              <i class="fa fa-trash"></i>';
                $html .= '          </a>';
                $html .= '      </div>';
            }

            $html .= '    </div>';
            $html .= '</div>';

            array_push($arrArticle, $html);
            array_push($arrArticleIds, $arrArticleIds);
        }


        if ($request->ajax()){
            if ($len > 0) {
                return Response::json([
                    'articles' => $arrArticle,
                    'ids' => $arrArticleIds,
                    'length' => $len,
                ], 200);
            } else {
                return Response::json([
                    'result' => 'There is no more record'
                ], 200);
            }

        }

    }

}
