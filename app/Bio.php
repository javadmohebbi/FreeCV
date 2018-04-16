<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Bio
 *
 * @mixin \Eloquent
 */
class Bio extends Model
{
    protected $table = 'bio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language_id', 'image_id', 'bio'
    ];


    public $timestamps = false;

    /**
     * @param $lang -> Language code -> Like en, es, fa, ... -> App::getLocale()
     * @param $fallBackLangId -> if it's not null, Use the Language Fallback ID
     * @return mixed -> Return the requested Bio
     */
    public function getBio($lang, $fallBackLangId = null){
        $language = Language::select('id')->where('short', '=', $lang)->first();
        if (isset($language)){
            $language = $language->id;
        } else {
            $language = 1;
        }
        $bio = $this->select()->where('language_id', '=', $language)->first();
        if (isset($bio)){
            return $bio;
        } else {
            if ($fallBackLangId != null) {
                $fallback_bio = $this->select()->where('language_id', '=', $this->fallBackLangId)->first();
                return $fallback_bio;
            } else {
                return false;
            }
        }
    }


    /**
     * @param $lang -> Language code -> Like en, es, fa, ... -> App::getLocale()
     * @param Bio|null $bio -> Eloquent Modal of Bio
     * @param $htmlBio -> HTML that user set inside web
     * @return Bio|mixed -> Return Eloquent model of saved Bio
     */
    public function setBio($lang, Bio $bio=null, $htmlBio){
        $lang_id = Language::getLanguageId($lang);
        if (isset($bio)){
            $bio->fill([
                'bio' => $htmlBio,
            ])->save();
            return $bio;
        } else {
            $BioId = Bio::insertGetId([
                'language_id' => $lang_id,
                'bio' => $htmlBio
            ]);
            $bio = $this->select()->where('id', '=', $BioId)->first();

            return $bio;
        }
    }

}
