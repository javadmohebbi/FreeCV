<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\StoreComment;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Language;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\User;
use Yajra\DataTables\DataTables;

class CommentController extends Controller
{
    protected $comment;
    protected $lang;

    function __construct(Comment $comment) {
        $this->comment = $comment;
        $this->lang = \App::getLocale();
    }


    /**
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxGetCommentsBelongsToKb(Article $article){
        if(User::isAdmin()) {
            $comments = Comment::select()
                ->where('article_id', '=', $article->id)
                ->orderBy('created_at', 'desc')
                ->get();


            return DataTables::of($comments)
                ->editColumn('created_at', function ($comment){
                    $settings = new Setting();
                    return $settings->getHumanReadableDateTime($comment->created_at, App::getLocale());
                })
                ->editColumn('name', function ($comment){
                    if ($comment->user_id != null) {
                        $user = User::select('name')
                            ->where('id', '=', $comment->user_id)->first();
                        return $user->name;
                    } else {
                        return $comment->name;
                    }
                })
                ->editColumn('email', function ($comment){

                    if ($comment->user_id != null) {
                        $user = User::select('email')
                            ->where('id', '=', $comment->user_id)->first();
                        return '<a href="mailto:' . $user->email . '">' . $user->email . '</a>';
                    } else {
                        return '<a href="mailto:' . $comment->email . '">' . $comment->email . '</a>';
                    }
                })
                ->editColumn('status', function ($comment){
                    switch ($comment->status){
                        case 2:
                            return '<span class="text-success" id="status-'.$comment->id.'">' .
                                trans('ocv.approved') . '</span>';
                        case 1:
                            return '<span class="text-warning" id="status-'.$comment->id.'">' .
                                trans('ocv.not_approved') . '</span>';
                        case 0:
                            return
                                '<span class="text-warning" id="unread-status-'.$comment->id.'">' .
                                '<label class="label label-info">' . trans('ocv.unread') . '</label>'
                                . '&nbsp;' . trans('ocv.not_approved') . '</span>';
                    }
                })
                ->editColumn('operation', function ($comment){
                    $html = '';
                    switch ($comment->status){
                        case 2:
                            $html .= '<a class="btn btn-xs btn-warning btn-hide" data-id="' . $comment->id .
                                '" id="btnHide-' . $comment->id . '">'.
                                '<i class="fa fa-close"></i>&nbsp;&nbsp;' . trans('ocv.hide') . '</a>&nbsp;';
                            break;
                        case 1:
                            $html .= '<a class="btn btn-xs btn-success btn-approve" data-id="' . $comment->id .
                                '" id="btnApprove-' . $comment->id . '">'.
                                '<i class="fa fa-check"></i>&nbsp;&nbsp;' . trans('ocv.approve') . '</a>&nbsp;';
                            break;
                        case 0:
                            $html .= '<a class="btn btn-xs btn-success btn-approve" data-id="' . $comment->id .
                                '" id="btnApprove-' . $comment->id . '">'.
                                '<i class="fa fa-check"></i>&nbsp;&nbsp;' . trans('ocv.approve') . '</a>&nbsp;';
                            break;

                    }
                    $html .= '<a class="btn btn-xs btn-danger btn-delete" data-id="' . $comment->id .
                          '" id="btnDelete-' . $comment->id . '">'.
                          '<i class="fa fa-trash"></i>&nbsp;&nbsp;' . trans('ocv.delete') . '</a>&nbsp;';
                    $html .= ' <img class="loading hidden" src="' . asset('public/img/ajax-loader.gif') .
                        '" id="loading-' . $comment->id  . '"' .
                        ' alt="loading"/>';
                    return $html;
                })
                ->rawColumns(['created_at', 'name', 'email','status', 'operation'])
                ->make(true);
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxDeleteComment(Comment $comment){
        if(User::isAdmin()) {
            $comment->delete();
            return Response::json([
                'error' => true,
            ], 200);
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxHideComment(Comment $comment){
        if(User::isAdmin()) {
            $comment->fill(['status' => 1])->save();
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxApproveComment(Comment $comment){
        if(User::isAdmin()) {
            $comment->fill(['status' => 2])->save();
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxGetUnreadComments(){
        if(User::isAdmin()) {
            $comments = Comment::select()
                ->where('status', '=', 0)
                ->orderBy('created_at', 'desc')
                ->get();


            return DataTables::of($comments)
                ->editColumn('created_at', function ($comment){
                    $settings = new Setting();
                    $html = $settings->getHumanReadableDateTime($comment->created_at, App::getLocale());
                    $article = Article::select()->where('id', '=', $comment->article_id)->first();
                    $html .= '<br/><a href="' . url( App::getLocale() . '/blog/' . $article->slug) . '" ' .
                        ' target="_blank">' . $article->title . '</a>';
                    return $html;
                })
                ->editColumn('name', function ($comment){
                    if ($comment->user_id != null) {
                        $user = User::select('name')
                            ->where('id', '=', $comment->user_id)->first();
                        return $user->name;
                    } else {
                        return $comment->name;
                    }
                })
                ->editColumn('email', function ($comment){

                    if ($comment->user_id != null) {
                        $user = User::select('email')
                            ->where('id', '=', $comment->user_id)->first();
                        return '<a href="mailto:' . $user->email . '">' . $user->email . '</a>';
                    } else {
                        return '<a href="mailto:' . $comment->email . '">' . $comment->email . '</a>';
                    }
                })
                ->editColumn('status', function ($comment){
                    switch ($comment->status){
                        case 2:
                            return '<span class="text-success" id="status-'.$comment->id.'">' .
                                trans('ocv.approved') . '</span>';
                        case 1:
                            return '<span class="text-warning" id="status-'.$comment->id.'">' .
                                trans('ocv.not_approved') . '</span>';
                        case 0:
                            return
                                '<span class="text-warning" id="status-'.$comment->id.'">' .
                                '<label class="label label-info">' . trans('ocv.unread') . '</label>'
                                . '&nbsp;' . trans('ocv.not_approved') . '</span>';
                    }
                })
                ->editColumn('operation', function ($comment){
                    $html = '';
                    switch ($comment->status){
                        case 2:
                            $html .= '<a class="btn btn-xs btn-warning btn-hide" data-id="' . $comment->id .
                                '" id="btnHide-' . $comment->id . '">'.
                                '<i class="fa fa-close"></i>&nbsp;&nbsp;' . trans('ocv.hide') . '</a>&nbsp;';
                            break;
                        case 1:
                            $html .= '<a class="btn btn-xs btn-success btn-approve" data-id="' . $comment->id .
                                '" id="btnApprove-' . $comment->id . '">'.
                                '<i class="fa fa-check"></i>&nbsp;&nbsp;' . trans('ocv.approve') . '</a>&nbsp;';
                            break;
                        case 0:
                            $html .= '<a class="btn btn-xs btn-success btn-approve" data-id="' . $comment->id .
                                '" id="btnApprove-' . $comment->id . '">'.
                                '<i class="fa fa-check"></i>&nbsp;&nbsp;' . trans('ocv.approve') . '</a>&nbsp;';
                            break;

                    }
                    $html .= '<a class="btn btn-xs btn-danger btn-delete" data-id="' . $comment->id .
                        '" id="btnDelete-' . $comment->id . '">'.
                        '<i class="fa fa-trash"></i>&nbsp;&nbsp;' . trans('ocv.delete') . '</a>&nbsp;';
                    $html .= ' <img class="loading hidden" src="' . asset('public/img/ajax-loader.gif') .
                        '" id="loading-' . $comment->id  . '"' .
                        ' alt="loading"/>';
                    return $html;
                })
                ->rawColumns(['created_at', 'article_id' , 'name', 'email','status', 'operation'])
                ->make(true);
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxUpdateUnreadComments() {
        if (User::isAdmin()) {
            $comments = Comment::select()
                ->where('status', '=', 0)
                ->orderBy('created_at', 'desc')
                ->get();

            $html = '';
            $notIconHtml = '';
            if (count($comments) > 0){
                $html .= '<a href="javascript:void(0);" id="btnUnreadComments" title="'.
                    trans_choice('ocv.msg_unread_comments_no_html', count($comments), ['count' => count($comments)]) . '">';
                $html .= '      <i class="fa fa-comments"></i>';
                $html .= '      '. trans_choice('ocv.msg_unread_comments', count($comments), ['count' => count($comments)]);
                $html .= '</a>';

                $notIconHtml .= '<i class="text-info fa fa-bell"></i>';
            } else {
                $html .= '<a href="javascript:void(0);">';
                $html .= '  <i class="fa fa-exclamation-triangle"></i>';
                $html .= '  '.trans('ocv.dt_empty');
                $html .= '</a>';

                $notIconHtml .= '<i class="fa fa-bell-o"></i>';
            }


            return Response::json([
                'count' => count($comments),
                'html' => $html,
                'htmlIcon' => $notIconHtml,
                'notify' => trans_choice('ocv.msg_unread_comments_no_html', count($comments), ['count' => count($comments)])
            ], 200);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxLoadMoreComments(Article $article, Request $request){

        $comments = new Comment();
        $comments = $comments->getApprovedComments($article->id);

        $len = (count($comments));
        $arrComments = [];
        $arrCommentIds = [];
        foreach ($comments as $index => $comment) {
            $html = '';

            $commenterName = new Comment();
            $commenterName = $commenterName->getCommenterName($comment->id);

            $commenterEmail = new Comment();
            $commenterEmail = $commenterEmail->getCommenterEmail($comment->id);

            $commentDate = new Setting();
            $commentDate = $commentDate->getHumanReadableDateTime($comment->created_at, App::getLocale());

            $odd = '';
            if ($index % 2 == 0) { $odd = ' odd '; }

            $isRTL = '';
            if (isRTL()) {
                $isRTL = ' text-right';
            }

            $html .= '<div class="col-sm-12 blog-comment'.$odd.'"';
            $html .= '  style="padding: 15px" data-id="'.$comment->id.'">';
            $html .= '  <div class="col-sm-12 ltr '.$isRTL.'" data-id="{{ $comment->id }}">';
            $html .= '    <label class="label label-default'.$isRTL.'">';
            $html .= '      <i class="fa fa-calendar-o"></i>';
            $html .= '      '. $commentDate;
            $html .= '    </label>';
            $html .= '    <label class="label label-info '.$isRTL.'" style="margin: 5px">';
            $html .= '      <i class="fa fa-user"></i>';
            $html .= '      ' . $commenterName;
            $html .= '    </label>';
            $html .= '  </div>';
            $html .= '  <div class="col-sm-12 comments" data-id="'.$comment->id.'">';
            $html .= '      <i class="fa fa-comment"></i>';
            $html .= '      '. $comment->comments;
            $html .= '  </div>';
            $html .= '</div>';

            array_push($arrComments, $html);
        }


        if ($request->ajax()){
            if ($len > 0) {
                return Response::json([
                    'comments' => $arrComments,
                    'length' => $len,
                ], 200);
            } else {
                return Response::json([
                    'result' => 'There is no more record'
                ], 200);
            }

        }

    }



    function ajaxInsertComment(Article $article, StoreComment $request) {
        $dataNeedToBeSaved = [];
        $dataNeedToBeSaved['status'] = 0;
        if (!auth()->check()) {
            $dataNeedToBeSaved['name'] = $request->name;
            $dataNeedToBeSaved['email'] = $request->email;
            $dataNeedToBeSaved['user_id'] = null;
        } else {
            $dataNeedToBeSaved['name'] = null;
            $dataNeedToBeSaved['email'] = null;
            $dataNeedToBeSaved['user_id'] = auth()->user()->id;
            if (checkIfAdmin()) {
                $dataNeedToBeSaved['status'] = 2;
            }

        }
        $dataNeedToBeSaved['article_id'] = $article->id;
        $dataNeedToBeSaved['comments'] = $request->comments;



        $id = Comment::insertGetId([
            'name' => $dataNeedToBeSaved['name'],
            'email' => $dataNeedToBeSaved['email'],
            'user_id' => $dataNeedToBeSaved['user_id'],
            'article_id' => $dataNeedToBeSaved['article_id'],
            'comments' => $dataNeedToBeSaved['comments'],
            'status' => $dataNeedToBeSaved['status'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return Response::json([
            'result' => true,
            'msg' => trans('ocv.msg_comment_sent')
        ], 200);

    }

}
