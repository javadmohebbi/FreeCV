<?php

namespace App\Http\Controllers;

use App\Article;
use App\Tag;
use Illuminate\Http\Request;

class SitemapController extends Controller
{


    public function index(){

        $kbs = Article::select()->where('enabled', '=', 1)
            ->orderBy('updated_at', 'DESC')
            ->get();

        $tags = Tag::get();

        $arr = [];


        array_push($arr, [
            'kbs' => $kbs,
            'total' => count($kbs->toArray())
        ]);

        array_push($arr, [
            'tags' => $tags,
            'total' => count($tags->toArray())
        ]);


        return response()->view('templates.sitemap', compact(
            'arr'
        ))->header('Content-Type', 'text/xml');
    }



}
