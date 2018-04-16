<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagItem extends Model
{
    protected $table = 'tag_items';

    /**
     * @param $tagId
     * @param $articleId
     * @return $tagItemId
     */
    public function insertTagItems($tagId, $articleId){
        $arrData = null;
        $returnId = null;
        $arrData = [
            'tag_id' => $tagId,
            'article_id' => $articleId,
        ];

        $returnId = $this->insertGetId($arrData);
        return $returnId;
    }


    /**
     * @param $articleId
     * @return mixed
     */
    public function getTagItemsByBelongsId($articleId){
        return $this->select()->where('article_id', '=', $articleId)->get();
    }


    /**
     * @param $articleId
     * @return mixed
     */
    public function deleteTagItemsByBelongsId($articleId){
        return $this->where('article_id', '=', $articleId)->delete();
    }



    /**
     * @param $tagId
     * @return mixed
     */
    public static function getKnowledgeBasesBelongsToTag($tagId){
        $articles = Article::join('tag_items', 'articles.id', '=', 'tag_items.article_id')
            ->select('articles.*')
            ->where('articles.enabled', '=', '1')
            ->where('tag_items.tag_id', '=', $tagId)
            ->get();
        return $articles;
    }


    /**
     * @param $tagId
     * @return mixed
     */
    public static function getKnowledgeBasesBelongsToTagPaginate($tagId){
        $langId = Language::getLanguageId(\App::getLocale());
        $articles = Article::join('tag_items', 'articles.id', '=', 'tag_items.article_id')
            ->select('articles.*')
            ->where('articles.enabled', '=', '1')
            ->where('articles.language_id', '=', $langId)
            ->where('tag_items.tag_id', '=', $tagId)
            ->orderBy('created_at', 'desc')
            ->paginate(1);
        return $articles;
    }


}
