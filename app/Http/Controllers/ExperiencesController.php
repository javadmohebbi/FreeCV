<?php

namespace App\Http\Controllers;

use App\Experience;
use App\Http\Requests\AddNewExperience;
use App\Http\Requests\UpdateExperience;
use App\Language;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

class ExperiencesController extends Controller
{
    protected $experience;
    protected $lang;

    function __construct(Experience $experience) {
        $this->experience = $experience;
        $this->lang = App::getLocale();
    }


    function getExperience(Experience $experience){
        if(User::isAdmin()) {
            return Response::json([
                'id' => $experience->id,
                'name' => $experience->name,
                'badge' => Experience::getBadge($experience->is_present),
                'from_year' => $experience->from_year,
                'from_month' => Experience::getMonth($experience->from_month),
                'to_year' => Experience::checkToYear($experience->to_year, $experience->is_present),
                'to_month' => Experience::getMonth($experience->to_month, $experience->is_present),
                'link' => Experience::checkLink($experience->link),
                'description' => $experience->description,

                'from_m' => $experience->from_month,
                'from_y' => $experience->from_year,
                'to_m' => $experience->to_month,
                'to_y' => $experience->to_year,
                'is_now' => $experience->is_present,
            ], 200);

        } else {
            return Response::json([
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }




    /**
     * @param AddNewExperience $request
     * @return \Illuminate\Http\JsonResponse
     */
    function addNewExperience(AddNewExperience $request){
        if(User::isAdmin()) {
            $langId = Language::getLanguageId($this->lang);

            if ((int)$request->is_present != 1){
                if( (int)$request->to_year < (int)$request->from_year){
                    return Response::json([
                        'msg' => trans('ocv.msg_to_year_from'),
                    ], 422);
                }
            }
            if( (int)$request->to_year == (int)$request->from_year){
                if( (int)$request->to_month < (int)$request->from_month){
                    return Response::json([
                        'msg' => trans('ocv.msg_to_month_from'),
                    ], 422);
                }

            }

            $project = Experience::insertGetId([
                'language_id' => $langId,
                'name' => $request->name,
                'from_month' => $request->from_month,
                'from_year' => $request->from_year,
                'is_present' => $request->is_present,
                'to_month' => $request->to_month,
                'to_year' => $request->to_year,
                'link' => $request->link,
                'description' => $request->description,
            ]);


            return Response::json([
                'error' => false,

                'id' => $project,
                'name' => $request->name,
                'badge' => Experience::getBadge($request->is_present),
                'from_year' => $request->from_year,
                'from_month' => Experience::getMonth($request->from_month),
                'to_year' => Experience::checkToYear($request->to_year, $request->is_present),
                'to_month' => Experience::getMonth($request->to_month, $request->is_present),
                'link' => Experience::checkLink($request->link),
                'description' => $request->description,


                'to_m' => $request->to_month, // This data will use \
                'to_y' => $request->to_year, //  to re-arrange the  \
                'is_now' => $request->is_present, // time-line.

            ], 200);
        } else {
            return Response::json([
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }


    /**
     * @param UpdateExperience $request
     * @param Experience $experience
     * @return \Illuminate\Http\JsonResponse
     */
    function updateExperience(UpdateExperience $request, Experience $experience){
        if(User::isAdmin()) {
            $langId = Language::getLanguageId($this->lang);


            if ((int)$request->is_present != 1){
                if( (int)$request->to_year < (int)$request->from_year){
                    return Response::json([
                        'msg' => trans('ocv.msg_to_year_from'),
                    ], 422);
                }
            }
            if( (int)$request->to_year == (int)$request->from_year){
                if( (int)$request->to_month < (int)$request->from_month){
                    return Response::json([
                        'msg' => trans('ocv.msg_to_month_from'),
                    ], 422);
                }

            }




            $experience->fill([
                'language_id' => $langId,
                'name' => $request->name,
                'from_month' => $request->from_month,
                'from_year' => $request->from_year,
                'is_present' => $request->is_present,
                'to_month' => $request->to_month,
                'to_year' => $request->to_year,
                'link' => $request->link,
                'description' => $request->description,
            ])->save();


            return Response::json([
                'error' => false,
                'id' => $experience->id,
                'name' => $request->name,
                'badge' => Experience::getBadge($request->is_present),
                'from_year' => $request->from_year,
                'from_month' => Experience::getMonth($request->from_month),
                'to_year' => Experience::checkToYear($request->to_year, $request->is_present),
                'to_month' => Experience::getMonth($request->to_month, $request->is_present),
                'link' => Experience::checkLink($request->link),
                'description' => $request->description,

                'to_m' => $request->to_month, // This data will use \
                'to_y' => $request->to_year, //  to re-arrange the  \
                'is_now' => $request->is_present, // time-line.

            ], 200);
        } else {
            return Response::json([
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }




    function destroyExperience(Experience $experience){
        if(User::isAdmin()) {

            $experience->delete();
            return Response::json([
                'delete' => true
            ], 200);

        } else {
            return Response::json([
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }
}
