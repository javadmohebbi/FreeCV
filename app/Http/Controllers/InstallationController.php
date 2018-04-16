<?php

namespace App\Http\Controllers;

use App\Bio;
use App\Http\Requests\ValidateDBRequest;
use App\Image;
use App\Installation;
use App\InstallationWizardModel;
use App\Setting;
use App\User;
use App\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Exception;
use App\Language;

class InstallationController extends Controller
{



    function __construct() {
        $this->getURL();
    }

    protected function getURL(){
        $url = 'http://' . $_SERVER['SERVER_NAME'];
        $serverPort = $_SERVER['SERVER_PORT'];
        if ($serverPort == 443 || $serverPort == 80) {
            $serverPort = '';
        } else {
            $url .= ':'.$serverPort .'/';
        }
        config(['app.url'=> $url]);
    }

    /**
     * Show installation window
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function installWindow() {

        $this->getURL();


        $check = false;
        try {

            Language::get();
            $lang = Language::get();

            $check = true;

        } catch (Exception $e){

            try {





                Artisan::call('clear');
                Artisan::call('clear-compiled');
                Artisan::call('view:clear');
                Artisan::call('route:clear');
                Artisan::call('cache:clear');


                //InstallationWizardModel::setEnvironmentValue('APP_ENV', 'production');

                /*$appKey = Artisan::output();
                preg_match_all("/\[[^\]]*\]/", $appKey, $matches);
                $appKey = $matches[0][0];
                $appKey = substr($appKey, 1, strlen($appKey)-2);*/

            } catch (Exception $exceptionGenerateKey) {
                $error = trans('ocv.installation_unknown_error',
                    ['error'=>$exceptionGenerateKey->getCode().' | '.$exceptionGenerateKey->getMessage()]);

                return view('installation.error', compact('error'));
            }



            return view('installation.install');


        }
        if ($check) { return Response::redirectTo('/', 302); }


    }


    /**
     * Install APP or Show error
     * @param ValidateDBRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function installApp(ValidateDBRequest $request) {

        $this->getURL();


        $userEmail = $request->get('email');
        $userPassword = $request->get('password');

        $dbConnection = 'mysql';
        $dbHost = $request->get('db_host');
        $dbPort = $request->get('db_port');
        $dbNAME = $request->get('db_name');
        $dbUser = $request->get('db_usern');
        $dbPass = $request->get('db_passn');
        $dbPri = 'ocv_';


        $appKey = null;


        $webURL = url('/');

        InstallationWizardModel::setEnvironmentValue('APP_ENV', 'local');
        InstallationWizardModel::setEnvironmentValue('APP_DEBUG', 'true');
        InstallationWizardModel::setEnvironmentValue('APP_URL', config('app.url'));
        InstallationWizardModel::setEnvironmentValue('DB_CONNECTION', $dbConnection);
        InstallationWizardModel::setEnvironmentValue('DB_HOST', $dbHost);
        InstallationWizardModel::setEnvironmentValue('DB_PORT', $dbPort);
        InstallationWizardModel::setEnvironmentValue('DB_DATABASE', $dbNAME);
        InstallationWizardModel::setEnvironmentValue('DB_USERNAME', $dbUser);
        InstallationWizardModel::setEnvironmentValue('DB_PASSWORD', $dbPass);
        InstallationWizardModel::setEnvironmentValue('DB_TABLE_PREFIX', $dbPri);



        try {
            Artisan::call('config:cache');
            Artisan::call('migrate');


            User::create([
                'id' => 99,
                'email' => $userEmail,
                'password' => bcrypt($userPassword),
                'name' => 'Admin',
                'is_admin' => 1,
                'enabled' => 1,
            ]);
            UserInformation::create([
                'user_id' => 99,
                'first_name' => 'Admin',
                'last_name' => 'Admin'
            ]);


            Image::create([
                'id' => 99,
                'path' => 'bio.jpg',
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            ]);



            if ($request->segment(1) == 'fa') {
                Language::create([
                    'name' => 'پارسی',
                    'short' => 'fa',
                    'enabled' => 1,
                    'is_rtl' => 1 // RTL
                ]);
                Language::create([
                    'name' => 'English',
                    'short' => 'en',
                    'enabled' => 1,
                    'is_rtl' => 2 // LTR
                ]);
                Bio::create([
                    'language_id' => 2,
                    'image_id' => 99,
                    'bio' => 'My name is YOURNAME. I have more than N years experience in WHATEVER. I really motivated by new challenges and excellent approach to achieve success! ...',
                ]);
                Bio::create([
                    'language_id' => 1,
                    'image_id' => 99,
                    'bio' => 'من، ---- هستم. حدود N سال در زمینه ------- تجربه کار دارم. از چالش های جدید بسیار استقبال می کنم و معمولا تمام تلاشم رو می کنم که این چالش ها رو با موفقیت پشت سر بگذارم.',
                ]);

            } else {
                Language::create([
                    'name' => 'English',
                    'short' => 'en',
                    'enabled' => 1,
                    'is_rtl' => 2 // LTR
                ]);
                Language::create([
                    'name' => 'پارسی',
                    'short' => 'fa',
                    'enabled' => 1,
                    'is_rtl' => 1 // RTL
                ]);
                Bio::create([
                    'language_id' => 1,
                    'image_id' => 99,
                    'bio' => 'My name is YOURNAME. I have more than N years experience in WHATEVER. I really motivated by new challenges and excellent approach to achieve success! ...',
                ]);
                Bio::create([
                    'language_id' => 2,
                    'image_id' => 99,
                    'bio' => 'من، ---- هستم. حدود N سال در زمینه ------- تجربه کار دارم. از چالش های جدید بسیار استقبال می کنم و معمولا تمام تلاشم رو می کنم که این چالش ها رو با موفقیت پشت سر بگذارم.',
                ]);
            }







            Setting::create([
                'language_id' => 1,
                'title' => 'FreeCV',
                'menu_long_title' => 'FREE CV',
                'menu_short_title' => 'FCV',
                'bio_enabled' => 1,
                'projects_enabled' => 1,
                'skills_enabled' => 1,
                'experiences_enabled' => 1,
                'contacts_enabled' => 1,
                'kb_enabled' => 1,
            ]);
            Setting::create([
                'language_id' => 2,
                'title' => 'FreeCV',
                'menu_long_title' => 'FREE CV',
                'menu_short_title' => 'FCV',
                'bio_enabled' => 1,
                'projects_enabled' => 1,
                'skills_enabled' => 1,
                'experiences_enabled' => 1,
                'contacts_enabled' => 1,
                'kb_enabled' => 1,
            ]);




            try {

                Artisan::call('config:cache');
                Artisan::call('key:generate');

                //InstallationWizardModel::setEnvironmentValue('APP_ENV', 'production');
                //InstallationWizardModel::setEnvironmentValue('APP_DEBUG', 'false');


            } catch (Exception $exceptionGenerateKey) {

                App::setLocale($request->segment(1));

                $error = trans('ocv.installation_unknown_error',
                    ['error'=>$exceptionGenerateKey->getCode().' | '.$exceptionGenerateKey->getMessage()]);

                return view('installation.error', compact('error'));
            }


            return Response::redirectTo('/', 302);



        } catch (Exception $e) {
            try {
                Artisan::call('migrate:rollback');
            } catch (Exception $exceptionRolbacl) {
                //
            }


            App::setLocale($request->segment(1));




            if ($e->getCode() == 1045) {
                $error = trans('ocv.installation_db_error');
                return view('installation.error', compact('error'));
            } else {
                $error = trans('ocv.installation_unknown_error', ['error'=>$e->getCode().' | '.$e->getMessage()]);
                return view('installation.error', compact('error'));
            }

        }



    }


    /**
     * Set local language
     * @param $local
     * @return \Illuminate\Http\Response
     */
    public function setLocal($local) {
        $this->getURL();

        App::setLocale($local);
        return Response::view('installation.install');
        //return Response::redirectTo('/install', 302);
    }
}
