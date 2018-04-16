<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language_id', 'title', 'slug', 'summary',
        'enabled', 'html_summary', 'html_desc',
        'user_id', 'article_category_id', 'gh',
        'image_id', 'viewed'
    ];


    /**
     * @param $lang
     * @param int $page
     * @return bool|null
     */
    public function getPaginate($lang, $page = 1)
    {
        $articles = null;
        $language = Language::select('id')
            ->where('short', '=', $lang)->first();
        if (isset($language)) {
            $language = $language->id;
        } else {
            $language = 1;
        }
        if (auth()->check() && auth()->user()->is_admin == 1){
            $articles = $this->select()
                ->where('language_id', '=', $language)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $articles = $this->select()
                ->where('enabled', '=', 1)
                ->where('language_id', '=', $language)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        if (isset($articles)) {
            return $articles;
        } else {
            return false;
        }

    }



    /**
     * @param $lang
     * @return null
     */
    public function getAll($lang)
    {
        $articles = null;
        $language = Language::select('id')
            ->where('short', '=', $lang)->first();
        if (isset($language)) {
            $language = $language->id;
        } else {
            $language = 1;
        }
        if (auth()->check() && auth()->user()->is_admin == 1){
            $articles = $this->select()
                ->where('language_id', '=', $language)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $articles = $this->select()
                ->where('enabled', '=', 1)
                ->where('language_id', '=', $language)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        if (isset($articles)) {
            return $articles;
        } else {
            return false;
        }

    }


    public function getArticleViewCount($articleId){
        $article = $this->select()
            ->where('id', '=', $articleId)
            ->first();
        return $article->viewed+0;
    }

}
