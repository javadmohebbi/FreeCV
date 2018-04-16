<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewSkill;
use App\Http\Requests\UpdateSkill;
use App\Skill;
use Illuminate\Http\Request;



use App\Language;
use App\User;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
class SkillsController extends Controller
{
    protected $skill;
    protected $lang;

    function __construct(Skill $skill) {
        $this->skill = $skill;
        $this->lang = App::getLocale();
    }



    function getSkill(Skill $skill){
        if(User::isAdmin()) {
            return Response::json([
                'id' => $skill->id,
                'skill' => $skill->skill,
                'color' => $skill->color,
                'color_css_class' => Skill::getColor($skill->color),
                'percentage' => $skill->percentage,
            ], 200);

        } else {
            return Response::json([
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }




    /**
     * @param AddNewSkill $request
     * @return \Illuminate\Http\JsonResponse
     */
    function addNewSkill(AddNewSkill $request){
        if(User::isAdmin()) {
            $langId = Language::getLanguageId($this->lang);

            $skill = Skill::insertGetId([
                'language_id' => $langId,
                'skill' => $request->skill,
                'color' => $request->color,
                'percentage' => $request->percentage,
            ]);

            return Response::json([
                'error' => false,
                'id' => $skill,
                'skill' => $request->skill,
                'color' => $request->color,
                'percentage' => $request->percentage,
                'color_css_class' => Skill::getColor($request->color),

            ], 200);

        } else {
            return Response::json([
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }


    /**
     * @param UpdateSkill $request
     * @param Skill $skill
     * @return \Illuminate\Http\JsonResponse
     */
    function updateSkill(UpdateSkill $request,Skill $skill){
        if(User::isAdmin()) {
            $langId = Language::getLanguageId($this->lang);


            $skill->fill([
                'language_id' => $langId,
                'skill' => $request->skill,
                'color' => $request->color,
                'percentage' => $request->percentage,
            ])->save();



            return Response::json([
                'error' => false,
                'id' => $skill->id,
                'skill' => $request->skill,
                'color' => $request->color,
                'color_css_class' => Skill::getColor($request->color),
                'percentage' => $request->percentage,

            ], 200);
        } else {
            return Response::json([
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }



    function destroySkill(Skill $skill){
        if(User::isAdmin()) {

            $skill->delete();
            return Response::json([
                'delete' => true
            ], 200);

        } else {
            return Response::json([
                'delete' => false,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }

}
