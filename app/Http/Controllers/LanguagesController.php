<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Language;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;

class LanguagesController extends Controller
{
    protected $language;
    protected $lang;

    function __construct(\App\Language $language) {
        $this->language = $language;
        $this->lang = \App::getLocale();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxGetLanguages(){
        if(User::isAdmin()) {
            $languages = \App\Language::select()
                ->orderBy('id', 'asc')
                ->get();

            return DataTables::of($languages)
                ->editColumn('enabled', function ($language){
                    switch ($language->enabled){
                        case 2:
                            return '<span class="text-success" id="lang-status-'.$language->id.'">' .
                                trans('ocv.inactive') . '</span>';
                        case 1:
                            return '<span class="text-warning" id="lang-status-'.$language->id.'">' .
                                trans('ocv.active') . '</span>';
                    }
                })
                ->editColumn('is_rtl', function ($language){
                    switch ($language->is_rtl){
                        case 2:
                            return '<label class="label label-info">'
                                    . '<i class="fa fa-arrow-right"></i>'
                                  .'</label>';
                        case 1:
                            return '<label class="label label-success" >'
                                    . '<i class="fa fa-arrow-left"></i>'
                                   .'</label>';
                    }
                })
                ->editColumn('operation', function ($language){
                    $html = '';
                    switch ($language->enabled){
                        case 2:
                            $html .= '<a class="btn btn-xs btn-success btn-lang-en" data-id="' . $language->id .
                                '" id="btnLangEn-' . $language->id . '">'.
                                '<i class="fa fa-check"></i>&nbsp;&nbsp;' . trans('ocv.enable') . '</a>&nbsp;';
                            break;
                        case 1:
                            $html .= '<a class="btn btn-xs btn-warning btn-lang-di" data-id="' . $language->id .
                                '" id="btnLangDi-' . $language->id . '">'.
                                '<i class="fa fa-close"></i>&nbsp;&nbsp;' . trans('ocv.disable') . '</a>&nbsp;';
                    }
                    $html .= ' <img class="loading hidden" src="' . asset('public/img/ajax-loader.gif') .
                        '" id="lang-loading-' . $language->id  . '"' .
                        ' alt="loading"/>';
                    return $html;
                })
                ->rawColumns(['enabled', 'is_rtl' , 'operation'])
                ->make(true);
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }


    /**
     * @param Language $language
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxEnableLanguage(\App\Language $language){
        if(User::isAdmin()) {

            $language->fill(['enabled' => 1])->save();
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }

    /**
     * @param Language $language
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxDisableLanguage(\App\Language $language){
        if(User::isAdmin()) {
            $availableLanguage = \App\Language::where('enabled', '=', 1)
                ->get()->toArray();
            if (count($availableLanguage) > 1) {
                $language->fill(['enabled' => 2])->save();
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_error_auth_403')
                ], 403);
            }
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }
}
