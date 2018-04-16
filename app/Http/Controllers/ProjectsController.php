<?php

namespace App\Http\Controllers;



use App\Http\Requests\AddNewProject;

use App\Http\Requests\UpdateProject;
use App\Language;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

class ProjectsController extends Controller
{
    protected $project;
    protected $lang;

    function __construct(Project $project) {
        $this->project = $project;
        $this->lang = App::getLocale();
    }


    function getProject(Project $project){
        if(User::isAdmin()) {
            return Response::json([
                'id' => $project->id,
                'name' => $project->name,
                'badge' => Project::getBadge($project->is_present),
                'from_year' => $project->from_year,
                'from_month' => Project::getMonth($project->from_month),
                'to_year' => Project::checkToYear($project->to_year, $project->is_present),
                'to_month' => Project::getMonth($project->to_month, $project->is_present),
                'link' => Project::checkLink($project->link),
                'description' => $project->description,

                'from_m' => $project->from_month,
                'from_y' => $project->from_year,
                'to_m' => $project->to_month,
                'to_y' => $project->to_year,
                'is_now' => $project->is_present,
            ], 200);

        } else {
            return Response::json([
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }




    /**
     * @param AddNewProject $request
     * @return \Illuminate\Http\JsonResponse
     */
    function addNewProject(AddNewProject $request){
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

            $project = Project::insertGetId([
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
                'badge' => Project::getBadge($request->is_present),
                'from_year' => $request->from_year,
                'from_month' => Project::getMonth($request->from_month),
                'to_year' => Project::checkToYear($request->to_year, $request->is_present),
                'to_month' => Project::getMonth($request->to_month, $request->is_present),
                'link' => Project::checkLink($request->link),
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
     * @param UpdateProject $request
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    function updateProject(UpdateProject $request,Project $project){
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




            $project->fill([
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
                'id' => $project->id,
                'name' => $request->name,
                'badge' => Project::getBadge($request->is_present),
                'from_year' => $request->from_year,
                'from_month' => Project::getMonth($request->from_month),
                'to_year' => Project::checkToYear($request->to_year, $request->is_present),
                'to_month' => Project::getMonth($request->to_month, $request->is_present),
                'link' => Project::checkLink($request->link),
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




    function destroyProject(Project $project){
        if(User::isAdmin()) {

            $project->delete();
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
