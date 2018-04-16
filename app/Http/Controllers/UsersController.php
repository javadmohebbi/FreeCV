<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    protected $user;
    protected $lang;

    /**
     * UsersController constructor.
     * @param User $user
     */
    function __construct(User $user) {
        $this->user = $user;
        $this->lang = \App::getLocale();
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxGetUsers(){
        if(User::isAdmin()) {
            $users = User::select()
                ->orderBy('id', 'asc')
                ->get();

            return DataTables::of($users)
                ->editColumn('enabled', function ($user){
                    switch ($user->enabled){
                        case 2:
                            return '<span class="text-warning" id="user-status-'.$user->id.'">' .
                                trans('ocv.inactive') . '</span>';
                        case 1:
                            return '<span class="text-success" id="user-status-'.$user->id.'">' .
                                trans('ocv.active') . '</span>';
                    }
                })
                ->editColumn('email', function ($user){
                    return '<a href="mailto:' . $user->email . '">' . $user->email . '</a>';
                })
                ->editColumn('is_admin', function ($user){
                    switch ($user->is_admin){
                        case 2:
                            return '<label id="is-admin-'.$user->id.'"  class="label label-info">'
                                . trans('ocv.no')
                                .'</label>';
                        case 1:
                            return '<label id="is-admin-'.$user->id.'" class="label label-success" >'
                                . trans('ocv.yes')
                                .'</label>';
                    }
                })
                ->editColumn('operation', function ($user){
                    $html = '';
                    if (auth()->user()->id != $user->id) {
                        switch ($user->enabled){
                            case 2:
                                $html .= '<a class="btn btn-xs btn-success btn-user-en" data-id="' . $user->id .
                                    '" id="btnUserEn-' . $user->id . '">'.
                                    '<i class="fa fa-check"></i>&nbsp;&nbsp;' . trans('ocv.enable') . '</a>&nbsp;';
                                break;
                            case 1:
                                $html .= '<a class="btn btn-xs btn-warning btn-user-di" data-id="' . $user->id .
                                    '" id="btnUserDi-' . $user->id . '">'.
                                    '<i class="fa fa-close"></i>&nbsp;&nbsp;' . trans('ocv.disable') . '</a>&nbsp;';
                        }
                    }

                    $adminUserCount = count(User::select()
                        ->where('is_admin', '=', '1')
                        ->where('enabled', '=', '1')
                        ->get());

                    switch ($user->is_admin){
                        case 2:
                            $html .= '<a class="btn btn-xs btn-danger btn-user-admin" data-id="' . $user->id .
                                '" id="btnUserAdmin-' . $user->id . '">'.
                                '<i class="fa fa-check"></i>&nbsp;&nbsp;' . trans('ocv.define_as_admin') . '</a>&nbsp;';
                            break;
                        case 1:
                            if ($user->id != auth()->user()->id) {
                                $html .= '<a class="btn btn-xs btn-info btn-user-normal" data-id="' . $user->id .
                                    '" id="btnUserNormal-' . $user->id . '">'.
                                    '<i class="fa fa-close"></i>&nbsp;&nbsp;' . trans('ocv.define_as_user') . '</a>&nbsp;';
                                break;
                            } else {
                                $html .= '-';
                            }

                    }

                    $html .= ' <img class="loading hidden" src="' . asset('public/img/ajax-loader.gif') .
                        '" id="user-loading-' . $user->id  . '"' .
                        ' alt="loading"/>';
                    return $html;
                })
                ->rawColumns(['enabled','is_admin', 'email', 'operation'])
                ->make(true);
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }


    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxEnableUser(User $user){
        if(User::isAdmin()) {
            $user->fill(['enabled' => 1])->save();
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxDisableUser(User $user){
        if(User::isAdmin()) {
            if (auth()->user()->id == $user->id) {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_user_disable_myself',['User'=>$user->name])
                ], 422); //
            }
            if ($user->is_admin == 2) {
                $user->fill(['enabled' => 2])->save();
                return Response::json(['result'=> true], 200);
            }
            $adminCount = count(User::select()
                ->where('is_admin', '=', 1)
                ->where('enabled', '=', 1)
                ->get());
            if ($adminCount > 1) {
                $user->fill(['enabled' => 2])->save();
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_user_disable_last_admin',['User'=>$user->name])
                ], 422); //
            }

        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxDefineAsAdminUser(User $user){
        if(User::isAdmin()) {
            $user->fill(['is_admin' => 1])->save();

            return Response::json([
                'stat' => trans('ocv.yes')
            ], 200);
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxDefineAsNormalUser(User $user){
        if(User::isAdmin()) {
            if ($user->id != auth()->user()->id) {
                $user->fill(['is_admin' => 2])->save();
                return Response::json([
                    'stat' => trans('ocv.no')
                ], 200);
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_user_disable_last_admin',['User'=>$user->name])
                ], 422); //
            }

        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }




}
