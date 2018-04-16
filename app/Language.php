<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mockery\CountValidator\Exception;

/**
 * App\Language
 *
 * @mixin \Eloquent
 */
class Language extends Model
{
    protected $table = 'languages';

    protected $fallBackLangId = 1;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'short', 'enabled', 'is_rtl'
    ];


    /**
     * @param int $langId -> get Lang Id
     * @return mixed -> Return short form -> en, es, fa, ...
     */
    public static function getDefaultLanguage($langId = 1){
        $language =  Language::where('id', '=',$langId)
            ->where('enabled', '=', 1)
            ->first();
        if (isset($language)) {
            return $language->short;
        } else {
            return false;
        }

    }

    /**
     * Get next first available language
     * @return mixed
     */
    public static function getNextFirstAvailableLanguage(){
        return Language::where('enabled', '=',1)
            ->orderBy('id', 'asc')
            ->first()->short;
    }


    /**
     * @param $short -> get Language short form. -> en, es, fa, ... -> App::getLocale
     * @return bool -> return True, when the language is available in the Database
     */
    public static function checkIfLangAvailable($short){

        $langId = Language::select()
            ->where('short', '=', $short)
            ->first();

        if(isset($langId)){
            return true;
        } else {
            return false;
        }
    }


    /**
     * @param $short -> get Language short form. -> en, es, fa, ... -> App::getLocale
     * @return int -> return Language ID from database
     */
    public static function getLanguageId($short, $fallbackLangId = 1){
        $langId = Language::select('id')
            ->where('short', '=', $short)
            ->first();
        if(isset($langId)){
            return $langId->id;
        } else {
            return $fallbackLangId; // English -> en
        }
    }

    /**
     * @param $short -> get Language short form. -> en, es, fa, ... -> App::getLocale
     * @return bool -> return True if the requested language is RTL, otherwise return false
     */
    public static function isRTL($short){
        try {
            $isRTL = Language::select('is_rtl')->where('short', '=', $short)
                ->first();

            if(isset($isRTL)){
                $isRTL = $isRTL->is_rtl;
            } else {
                return false;
            }

            if ($isRTL == 1){
                return true;
            } else {
                return false;
            }

        } catch (Exception $e){
            return false;
        }


    }
}
