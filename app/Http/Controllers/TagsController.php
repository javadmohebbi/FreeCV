<?php

namespace App\Http\Controllers;

use App\Tag;
use App\TagItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class TagsController extends Controller
{

    protected $tags;


    /**
     * TagsController constructor.
     * @param Tag $tags
     */
    function __construct(Tag $tags) {
        $this->tags = $tags;
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllTags(Request $request){

        $query = $request->query('query');

        $tags = Tag::select(['tag'])->where('tag', 'like',  '%'. $query . '%')->get();
        $data = [];
        foreach ($tags as $tag){
            array_push($data, $tag->tag);
        }
        /*$options['tags'] = $data;*/
        return Response::json($data);
    }



    /**
     * Get Items belongs to a tag
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getItemsBelongsToTag(Tag $tag){
        $kbs = TagItem::getKnowledgeBasesBelongsToTagPaginate($tag->id);
        $dataPassed['kbs'] = $kbs;
        $dataPassed['tag'] = $tag->tag;

        return view('templates.hashtag.index', compact('dataPassed'));

    }



}
