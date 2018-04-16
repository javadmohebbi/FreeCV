<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{


    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language_id', 'fav_icon_image_id', 'title', 'keywords', 'description',
        'bio_enabled', 'projects_enabled', 'skills_enabled', 'experiences_enabled',
        'contacts_enabled', 'kb_enabled', 'custom_js', 'custom_css', 'google_analytics',
        'menu_long_title', 'menu_short_title',
    ];


    /**
     * @param $dateTime
     * @param string $lang
     * @return string
     */
    public function getHumanReadableDateTime($dateTime, $lang='en') {
        if ($lang == 'fa') {
            $returnDateTime = \jDate::forge($dateTime)->ago();
        } elseif ($lang == 'en') {
            $returnDateTime = Carbon::createFromTimestamp(strtotime($dateTime))->diffForHumans();
        } else {
            $returnDateTime = $dateTime->format('Y-m-d h:m');
        }

        return $returnDateTime;
    }


    /**
     * Inser setting if selected language has no settings
     * @param $lang
     * @return null
     */
    public function insertSettingsIfNotExist($lang) {
        $langId = Language::select('id')->where('short', '=', $lang)->first()->id;
        if (!isset($langId)){
            return null;
        }
        $setting = $this->select()
            ->where('language_id', '=', $langId)
            ->first();
        if (isset($setting)) {
            return $setting;
        } else {
            $setting = null;
            $setting = $this->insertGetId(
                [
                    'language_id' => $langId,
                    'bio_enabled' => 0,
                    'projects_enabled' => 0,
                    'skills_enabled' => 0,
                    'experiences_enabled' => 0,
                    'contacts_enabled' => 0,
                    'kb_enabled' => 0,
                ]);
            if (isset($setting)) {
                return $this->select()->where('id', '=', $setting)->first();
            } else {
                return null;
            }
        }
    }



    /**
     * @param $lang
     * @return mixed
     */
    public function getLangId($lang){
        return Language::select()
            ->where('short', '=', $lang)
            ->first()->id;
    }




    /**
     * @param $lang
     * @return bool|null
     */
    public function getIsBioEnabled($lang){
            $setting = $this->select()
                ->where('bio_enabled', '=', 1)
                ->where('language_id', '=', $this->getLangId($lang))
                ->first();
            if (isset($setting)) {
                return true;
            } else {
                return false;
            }

    }



    /**
     * @param $lang
     * @return bool|null
     */
    public function getIsProjectEnabled($lang){

            $setting = $this->select()
                ->where('projects_enabled', '=', 1)
                ->where('language_id', '=', $this->getLangId($lang))
                ->first();
            if (isset($setting)) {
                return true;
            } else {
                return false;
            }

    }


    /**
     * @param $lang
     * @return bool|null
     */
    public function getIsSkillEnabled($lang){

            $setting = $this->select()
                ->where('skills_enabled', '=', 1)
                ->where('language_id', '=', $this->getLangId($lang))
                ->first();
            if (isset($setting)) {
                return true;
            } else {
                return false;
            }

    }



    /**
     * @param $lang
     * @return bool|null
     */
    public function getIsExperiencesEnabled($lang){

            $setting = $this->select()
                ->where('experiences_enabled', '=', 1)
                ->where('language_id', '=', $this->getLangId($lang))
                ->first();
            if (isset($setting)) {
                return true;
            } else {
                return false;
            }

    }



    /**
     * @param $lang
     * @return bool|null
     */
    public function getIsContactsEnabled($lang){

            $setting = $this->select()
                ->where('contacts_enabled', '=', 1)
                ->where('language_id', '=', $this->getLangId($lang))
                ->first();
            if (isset($setting)) {
                return true;
            } else {
                return false;
            }
    }



    /**
     * @param $lang
     * @return bool|null
     */
    public function getIsKbEnabled($lang){

            $setting = $this->select()
                ->where('kb_enabled', '=', 1)
                ->where('language_id', '=', $this->getLangId($lang))
                ->first();
            if (isset($setting)) {
                return true;
            } else {
                return false;
            }

    }


    /**
     * @param $lang
     * @return null
     */
    public function getWebTitle($lang){

            $setting = $this->select()
                ->where('language_id', '=', $this->getLangId($lang))
                ->first();
            if (isset($setting)) {
                return $setting->title;
            } else {
                return null;
            }

    }


    /**
     * @param $lang
     * @return null
     */
    public function getWebKeywords($lang){

            $setting = $this->select()
                ->where('language_id', '=', $this->getLangId($lang))
                ->first();
            if (isset($setting)) {
                return $setting->keywords;
            } else {
                return null;
            }
    }




    /**
     * @param $lang
     * @return null
     */
    public function getWebDescription($lang){

            $setting = $this->select()
                ->where('language_id', '=', $this->getLangId($lang))
                ->first();
            if (isset($setting)) {
                return $setting->description;
            } else {
                return null;
            }

    }


    /**
     * @param $lang
     * @return null
     */
    public function getWebMenuLongTitle($lang){

            $setting = $this->select()
                ->where('language_id', '=', $this->getLangId($lang))
                ->first();
            if (isset($setting)) {
                return $setting->menu_long_title;
            } else {
                return null;
            }
    }

    /**
     * @param $lang
     * @return null
     */
    public function getWebMenuShortTitle($lang){
        $setting = $this->select()
            ->where('language_id', '=', $this->getLangId($lang))
            ->first();
        if (isset($setting)) {
            return $setting->menu_short_title;
        } else {
            return null;
        }
    }


    /**
     * @param $lang
     * @return null
     */
    public function getCustomCss($lang){

            $setting = $this->select()
                ->where('language_id', '=', $this->getLangId($lang))
                ->first();
            if (isset($setting)) {
                return $setting->custom_css;
            } else {
                return null;
            }

    }


    /**
     * @param $lang
     * @return null
     */
    public function getCustomJs($lang){

            $setting = $this->select()
                ->where('language_id', '=', $this->getLangId($lang))
                ->first();
            if (isset($setting)) {
                return $setting->custom_js;
            } else {
                return null;
            }

    }

    /**
     * @param $lang
     * @return null
     */
    public function getGoogleAnalytics($lang){

            $setting = $this->select()
                ->where('language_id', '=', $this->getLangId($lang))
                ->first();
            if (isset($setting)) {
                return $setting->google_analytics;
            } else {
                return null;
            }

    }



}
