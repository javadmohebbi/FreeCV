<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Language;
use App\User;
use Illuminate\Support\Facades\Response;

class SettingsController extends Controller
{
    protected $setting;
    protected $lang;


    function __construct(Setting $setting) {
        $this->setting = $setting;
        $this->lang = App::getLocale();
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxEnableBio() {
        if(User::isAdmin()){
            $setting = new Setting();
            $setting = $setting->insertSettingsIfNotExist(App::getLocale());
            if (isset($setting)) {
                $setting->fill(['bio_enabled'=>1])->save();
                return Response::json([
                    'result' => true,
                    'menu-title' => trans('ocv.is_enabled') . ' ' . trans('ocv.click_to_disable')
                ], 200);
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_unknown_error_3')
                ], 500);
            }
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
    public function ajaxDisableBio() {
        if(User::isAdmin()){
            $setting = new Setting();
            $setting = $setting->insertSettingsIfNotExist(App::getLocale());
            if (isset($setting)) {
                $setting->fill(['bio_enabled'=>2])->save();
                return Response::json([
                    'result' => true,
                    'menu-title' => trans('ocv.is_disabled') . ' ' . trans('ocv.click_to_enable')
                ], 200);
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_unknown_error_3')
                ], 500);
            }
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
    public function ajaxEnableProjects() {
        if(User::isAdmin()){
            $setting = new Setting();
            $setting = $setting->insertSettingsIfNotExist(App::getLocale());
            if (isset($setting)) {
                $setting->fill(['projects_enabled'=>1])->save();
                return Response::json([
                    'result' => true,
                    'menu-title' => trans('ocv.is_enabled') . ' ' . trans('ocv.click_to_disable')
                ], 200);
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_unknown_error_3')
                ], 500);
            }
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
    public function ajaxDisableProjects() {
        if(User::isAdmin()){
            $setting = new Setting();
            $setting = $setting->insertSettingsIfNotExist(App::getLocale());
            if (isset($setting)) {
                $setting->fill(['projects_enabled'=>2])->save();
                return Response::json([
                    'result' => true,
                    'menu-title' => trans('ocv.is_disabled') . ' ' . trans('ocv.click_to_enable')
                ], 200);
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_unknown_error_3')
                ], 500);
            }
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
    public function ajaxEnableSkills() {
        if(User::isAdmin()){
            $setting = new Setting();
            $setting = $setting->insertSettingsIfNotExist(App::getLocale());
            if (isset($setting)) {
                $setting->fill(['skills_enabled'=>1])->save();
                return Response::json([
                    'result' => true,
                    'menu-title' => trans('ocv.is_enabled') . ' ' . trans('ocv.click_to_disable')
                ], 200);
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_unknown_error_3')
                ], 500);
            }
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
    public function ajaxDisableSkills() {
        if(User::isAdmin()){
            $setting = new Setting();
            $setting = $setting->insertSettingsIfNotExist(App::getLocale());
            if (isset($setting)) {
                $setting->fill(['skills_enabled'=>2])->save();
                return Response::json([
                    'result' => true,
                    'menu-title' => trans('ocv.is_disabled') . ' ' . trans('ocv.click_to_enable')
                ], 200);
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_unknown_error_3')
                ], 500);
            }
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
    public function ajaxEnableExperiences() {
        if(User::isAdmin()){
            $setting = new Setting();
            $setting = $setting->insertSettingsIfNotExist(App::getLocale());
            if (isset($setting)) {
                $setting->fill(['experiences_enabled'=>1])->save();
                return Response::json([
                    'result' => true,
                    'menu-title' => trans('ocv.is_enabled') . ' ' . trans('ocv.click_to_disable')
                ], 200);
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_unknown_error_3')
                ], 500);
            }
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
    public function ajaxDisableExperiences() {
        if(User::isAdmin()){
            $setting = new Setting();
            $setting = $setting->insertSettingsIfNotExist(App::getLocale());
            if (isset($setting)) {
                $setting->fill(['experiences_enabled'=>2])->save();
                return Response::json([
                    'result' => true,
                    'menu-title' => trans('ocv.is_disabled') . ' ' . trans('ocv.click_to_enable')
                ], 200);
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_unknown_error_3')
                ], 500);
            }
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
    public function ajaxEnableContacts() {
        if(User::isAdmin()){
            $setting = new Setting();
            $setting = $setting->insertSettingsIfNotExist(App::getLocale());
            if (isset($setting)) {
                $setting->fill(['contacts_enabled'=>1])->save();
                return Response::json([
                    'result' => true,
                    'menu-title' => trans('ocv.is_enabled') . ' ' . trans('ocv.click_to_disable')
                ], 200);
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_unknown_error_3')
                ], 500);
            }
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
    public function ajaxDisableContacts() {
        if(User::isAdmin()){
            $setting = new Setting();
            $setting = $setting->insertSettingsIfNotExist(App::getLocale());
            if (isset($setting)) {
                $setting->fill(['contacts_enabled'=>2])->save();
                return Response::json([
                    'result' => true,
                    'menu-title' => trans('ocv.is_disabled') . ' ' . trans('ocv.click_to_enable')
                ], 200);
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_unknown_error_3')
                ], 500);
            }
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
    public function ajaxEnableKb() {
        if(User::isAdmin()){
            $setting = new Setting();
            $setting = $setting->insertSettingsIfNotExist(App::getLocale());
            if (isset($setting)) {
                $setting->fill(['kb_enabled'=>1])->save();
                return Response::json([
                    'result' => true,
                    'menu-title' => trans('ocv.is_enabled') . ' ' . trans('ocv.click_to_disable')
                ], 200);
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_unknown_error_3')
                ], 500);
            }
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
    public function ajaxDisableKb() {
        if(User::isAdmin()){
            $setting = new Setting();
            $setting = $setting->insertSettingsIfNotExist(App::getLocale());
            if (isset($setting)) {
                $setting->fill(['kb_enabled'=>2])->save();
                return Response::json([
                    'result' => true,
                    'menu-title' => trans('ocv.is_disabled') . ' ' . trans('ocv.click_to_enable')
                ], 200);
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_unknown_error_3')
                ], 500);
            }
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSaveWebsiteInformation(Request $request) {
        if(User::isAdmin()){
            $setting = new Setting();
            $setting = $setting->insertSettingsIfNotExist(App::getLocale());
            if (isset($setting)) {
                $setting->fill([
                    'title'=>$request->input(['title']),
                    'keywords'=>$request->input(['keywords']),
                    'description'=>$request->input(['description']),
                    'menu_long_title'=>$request->input(['menu_long_title']),
                    'menu_short_title'=>$request->input(['menu_short_title'])
                ])->save();
                return Response::json([
                    'result' => true,
                    'msg' => trans('ocv.msg_information_saved')
                ], 200);
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_unknown_error_2')
                ], 500);
            }
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSaveWebsiteCustomization(Request $request) {
        if(User::isAdmin()){
            $setting = new Setting();
            $setting = $setting->insertSettingsIfNotExist(App::getLocale());
            if (isset($setting)) {
                $setting->fill([
                    'custom_css'=>$request->input(['custom_css']),
                    'custom_js'=>$request->input(['custom_js']),
                    'google_analytics'=>$request->input(['google_analytics']),
                ])->save();
                return Response::json([
                    'result' => true,
                    'msg' => trans('ocv.msg_information_saved')
                ], 200);
            } else {
                return Response::json([
                    'error' => true,
                    'msg' => trans('ocv.msg_unknown_error_2')
                ], 500);
            }
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }
    }




}
