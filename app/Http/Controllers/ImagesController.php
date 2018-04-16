<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\StoreArticleImage;
use App\Http\Requests\StoreBioImage;
use App\Image;
use App\User;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;

class ImagesController extends Controller
{
    protected $image;
    protected $bioImage = 'bio_';
    protected $uploadImage = 'upload_';

    public function __construct(){
        $this->image = New Image();
    }


    /**
     * Set Admin Bio Image
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSetBioImage(){

        if(User::isAdmin()) {

            $formData = Input::all();
            $photo = $formData['file'];

            $request = new StoreBioImage($formData);

            $validator = Validator::make($formData, $request->rules(), $request->messages());

            if ($validator->fails()) {
                return Response::json([
                    'error' => true,
                    'message' => $validator->messages()->first(),
                    'code' => 400
                ], 400);
            }

            $extension = $photo->getClientOriginalExtension();


            $allowed_filename = $this->createUniqueFilename($this->bioImage, $extension);
            $fullFilePath = base_path() . '/public/img/' . $allowed_filename;

            $imageMan = New ImageManager();

            $exBioImage = base_path() . '/public/img/' . Image::select()->where('id', '=', 99)->first()->path;

            $this->clearnExBioImage($exBioImage);

            $theImage = $imageMan->make($photo)->save($fullFilePath); //Save Original Size


            if (!$theImage) {
                /** Server Error */
                Return Response::json([
                    'error' => true,
                    'code' => 500,
                ], 500);
            } else {
                $bioImage = Image::select()->where('id', '=', 99)->first();
                $bioImage->fill([
                    'path' => $allowed_filename,
                    'updated_at' => new \DateTime()
                ])->save();

                Return Response::json([
                    'error' => false,
                    'image' => asset('/public/img/' . $allowed_filename),
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
     * Set Article Image
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSetArticleImage(Article $article){

        if(User::isAdmin()) {


            $imageId = $article->image_id;
            $imagePath = false;
            if ($imageId != null) {
                $imagePath = Image::select('path')
                    ->where('id', '=', $imageId)
                    ->first()->path;
            }




            $formData = Input::all();
            $photo = $formData['file'];

            $request = new StoreArticleImage($formData);

            $validator = Validator::make($formData, $request->rules(), $request->messages());

            if ($validator->fails()) {
                return Response::json([
                    'error' => true,
                    'message' => $validator->messages()->first(),
                    'code' => 400
                ], 400);
            }

            $extension = $photo->getClientOriginalExtension();


            $allowed_filename = $this->createUniqueFilename($article->id, $extension);
            $fullFilePath = base_path() . '/public/img/articles/' . $allowed_filename;

            $imageMan = New ImageManager();

            if ($imagePath != false) {
                $exImage = base_path() . '/public/img/articles/' . $imagePath;
                $this->clearnExBioImage($exImage);
            }


            $theImage = $imageMan->make($photo)->save($fullFilePath); //Save Original Size


            if (!$theImage) {
                /** Server Error */
                Return Response::json([
                    'error' => true,
                    'code' => 500,
                ], 500);
            } else {
                if ($imagePath != false) {
                    $image = Image::select()->where('id', '=', $imageId)->first();
                    $image->fill([
                        'path' => $allowed_filename,
                        'updated_at' => new \DateTime()
                    ])->save();
                } else {
                    $imageId = Image::insertGetId([
                        'path' => $allowed_filename,
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime()
                    ]);
                }

                $article->fill(['image_id' => $imageId])->save();


                Return Response::json([
                    'error' => false,
                    'image' => asset('public/img/articles/' . $allowed_filename),
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
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxDeleteArticleImage(Article $article){
        if(User::isAdmin()) {
            $imageId = $article->image_id;
            if ($imageId != null) {
                $image = Image::select()->where('id', '=', $imageId)->first();

                $article->fill([
                    'image_id' => null
                ])->save();
                $image->delete();
                $this->clearnExBioImage(base_path() . '/public/img/articles/' . $image->path);
                Return Response::json([
                    'result' => true,
                    'path' => asset('/public/img/default.jpg')
                ], 200);
            } else {
                Return Response::json([
                    'result' => true,
                    'path' => asset('/public/img/default.jpg')
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
     * Set Admin Bio Image
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxUploadImage(){

        if(User::isAdmin()) {

            $formData = Input::all();
            $photo = $formData['file'];

            $request = new StoreArticleImage($formData);

            $validator = Validator::make($formData, $request->rules(), $request->messages());

            if ($validator->fails()) {
                return Response::json([
                    'error' => true,
                    'message' => $validator->messages()->first(),
                    'code' => 400
                ], 400);
            }

            $extension = $photo->getClientOriginalExtension();


            $allowed_filename = $this->createUniqueFilename($this->uploadImage, $extension);
            $fullFilePath = base_path() . '/public/img/uploads/' . $allowed_filename;

            $imageMan = New ImageManager();

            $theImage = $imageMan->make($photo)->save($fullFilePath); //Save Original Size

            if (!$theImage) {
                /** Server Error */
                Return Response::json([
                    'error' => true,
                    'code' => 500,
                ], 500);
            } else {

                Return Response::json([
                    'error' => false,
                    'image' => asset('/public/img/uploads/' . $allowed_filename),
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
     * @param $prefix
     * @param $extension
     * @return string
     */
    protected function createUniqueFilename($prefix, $extension )
    {
        return $prefix . '_' . date('m-d-Y-his') . '.' . $extension;
    }




    /**
     * @param $exBioImage  Remove Ex Bio Image
     */
    protected function clearnExBioImage($exBioImage){
        $fullPath = realpath($exBioImage);
        if (is_writable($fullPath)){
            unlink($fullPath);
        }

    }

}
