<?php

namespace App\Http\Controllers;

use App\Bio;
use App\Http\Requests\BioRequest;
use App\Language;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

class BioController extends Controller
{
    protected $bio;
    protected $lang;

    function __construct(Bio $bio) {
        $this->bio = $bio;
        $this->lang = App::getLocale();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxGetBio(){
        if(User::isAdmin()) {
            $bio = $this->bio->getBio($this->lang);

            if ($bio != false) {
                return Response::json([
                    'id' => $bio->id,
                    'bio' => $bio->bio,
                    'image_id' => $bio->image_id,
                ], 200);
            } else {
                return Response::json([
                    'id' => null,
                    'bio' => '',
                    'image_id' => null,
                ], 200);
            }
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }

    }

    /**
     * @param BioRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxSetBio(BioRequest $request){
        if(User::isAdmin()){
            $langId = Language::getLanguageId($this->lang);
            $savedBio = null;
            if ($request->id != null) {
                $bio = Bio::select()->where('id', $request->id)->first();
                $savedBio = $bio;
            } else {
                $bio = null;
            }
            $savedBio = $this->bio->setBio($this->lang, $bio, $request->bio);

            return Response::json([
                'id' => $savedBio->id,
                'bio' => $savedBio->bio,
                'image_id' => $savedBio->image_id
            ], 200);
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }


    }


}
