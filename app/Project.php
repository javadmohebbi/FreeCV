<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language_id', 'name', 'disabled', 'from_month',
        'from_year', 'is_present', 'to_month', 'to_year', 'link', 'description',
    ];


    public $timestamps = false;


    /**
     * @param $lang
     * @param null $fallBackLangId
     * @return bool
     */
    public function getAll($lang, $fallBackLangId = 1){
        $language = Language::select('id')
            ->where('short', '=', $lang)->first();
        if (isset($language)){
            $language = $language->id;
        } else {
            $language = 1;
        }
        $projects = $this->select()
            ->orderBy('is_present', 'asc')
            ->orderBy('to_year', 'desc')
            ->orderBy('to_month', 'desc')
            ->where('language_id', '=', $language)
            ->where('disabled', '=', null)
            ->get();
        if (isset($projects)){
            return $projects;
        } else {
            if ($fallBackLangId != null) {
                $fallback_projects = $this->select()
                    ->orderBy('is_present', 'asc')
                    ->orderBy('to_year', 'desc')
                    ->orderBy('to_month', 'desc')
                    ->where('language_id', '=', $this->fallBackLangId)
                    ->where('disabled', '=', null)
                    ->get();
                return $fallback_projects;
            } else {
                return false;
            }
        }
    }


    /**
     * @param $isPresent
     * @return bool -> True -> if its current project
     */
    public static function getBadge($isPresent){
        if ($isPresent == 1){
            return true;
        } else {
            return false;
        }
    }


    /**
     * @param $month
     * @return \Illuminate\Contracts\Translation\Translator|string -> Month name or an space character
     */
    public static function getMonth($month, $isPresent=2){
        if ($isPresent == 2) {
            switch ($month){
                case 1:
                    return trans('ocv.month_1');
                case 2:
                    return trans('ocv.month_2');
                case 3:
                    return trans('ocv.month_3');
                case 4:
                    return trans('ocv.month_4');
                case 5:
                    return trans('ocv.month_5');
                case 6:
                    return trans('ocv.month_6');
                case 7:
                    return trans('ocv.month_7');
                case 8:
                    return trans('ocv.month_8');
                case 9:
                    return trans('ocv.month_9');
                case 10:
                    return trans('ocv.month_10');
                case 11:
                    return trans('ocv.month_11');
                case 12:
                    return trans('ocv.month_12');
                default:
                    return $month;
            }
        } else {
            return false;
        }

    }


    /**
     * @param $toYear
     * @param $isPresent
     * @return \Illuminate\Contracts\Translation\Translator|string
     */
    public static function checkToYear($toYear ,$isPresent){
        if ($isPresent == 2){
            return $toYear;
        } else {
            return trans('ocv.now');
        }
    }


    /**
     * @param $link
     * @return bool
     */
    public static function checkLink($link){
        if ($link != null){
            return $link;
        } else {
            return false;
        }
    }


}
