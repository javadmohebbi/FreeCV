<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Tag extends Model
{
    protected $table = 'tags';


    /**
     * Get All Tags
     * @return mixed
     */
    public function getTags(){
        return $this->distinct()->get();
    }


    /**
     * Get All Tags Belongs to an Article
     * @param $blogId
     * @return mixed
     */
    public function getTagsBelongsToBlog($blogId){
        $tagsItem = TagItem::select('tag_id')
            ->where('article_id', '=', $blogId)
            ->get();
        $arr = [];
        if (count($tagsItem) > 0) {
            foreach ($tagsItem as $tag) {
                array_push($arr, $tag->tag_id);
            }
        }

        $tags = $this->select('tag')
            ->whereIn('id', $arr)->get();

        return $tags;
    }


    /**
     * @param $tags
     * @param $articleId
     * @param string $whatTag
     */
    public function insertTags($tags, $articleId, $whatTag = 'product'){
        $splited_tags = array_map('rtrim', explode(',', $tags));
        $tagId = null;
        $tagItem = New TagItem();
        foreach ($splited_tags as $tag){
            $tagObj = $this->select()->where('tag', '=', $tag)
                ->first();
            if ($tagObj == null) {
                $tagId = $this->insertGetId([
                    'tag' => $tag
                ]);
            } else {
                $tagId = $tagObj->id;
            }
            $tagItem->insertTagItems($tagId, $articleId, $whatTag); // Add tag to TagItem Table
        }
    }

    /**
     * @param $tags
     * @param $articleId
     */
    public function editTags($tags, $articleId){
        $splited_tags = array_map('rtrim', explode(',', $tags));
        $tagItems = New TagItem();
        $arrTagIds = [];
        $tagItems = $tagItems->getTagItemsByBelongsId($articleId);
        foreach ($tagItems as $tagItem){
            array_push($arrTagIds, $tagItem->tag_id);
        }
        $tagItems = new TagItem();
        $tagItems->deleteTagItemsByBelongsId($articleId);
    }




    public function getMostUsedTags() {
       /** $tags = $this->select(['tags.tag', 'count(*)'])
            ->join('tag_items', 'on', 'tag_items.tag_id', '=', 'tags.id')
          */
       $settings = new Setting();
       $langId = $settings->getLangId(App::getLocale());

       $tags = $this->select(DB::raw('tag, count(*) as count'))
           ->join('tag_items', 'tags.id', '=', 'tag_items.tag_id')
           ->join('articles', 'articles.id', '=', 'tag_items.article_id')
           ->where('articles.language_id', '=', $langId)
           ->groupBy('tags.tag')
           ->get()->take(10);
       return $tags;
    }


}
