<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skills';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language_id', 'skill', 'disabled', 'color',
        'percentage',
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
        $skills = $this->select()
            ->orderBy('id', 'desc')
            ->where('language_id', '=', $language)
            ->where('disabled', '=', null)
            ->get();
        if (isset($skills)){
            return $skills;
        } else {
            if ($fallBackLangId != null) {
                $fallback_skills = $this->select()
                    ->orderBy('id', 'desc')
                    ->where('language_id', '=', $this->fallBackLangId)
                    ->where('disabled', '=', null)
                    ->get();
                return $fallback_skills;
            } else {
                return false;
            }
        }
    }


    /**
     * @param $color
     * @return \Illuminate\Contracts\Translation\Translator|string -> Color name
     */
    public static function getColor($color){
        switch ($color){
            case 1:
                return 'progress-bar-danger';
            case 2:
                return 'progress-bar-success';
            case 3:
                return 'progress-bar-warning';
            case 4:
                return ' ';
            case 5:
                return 'progress-bar-info';
            default:
                return ' ';
        }
    }
}
