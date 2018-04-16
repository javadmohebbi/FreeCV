<?php

namespace App;

use App\Http\Requests\ContactRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Contact extends Model
{
    protected $table = 'contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language_id', 'user_id', 'email', 'tell',
        'fb', 'tw', 'yt', 'ig', 'li', 'gh',
        'tg', 'gp', 'pn',
    ];


    public $timestamps = false;


    /**
     * @param $lang
     * @param null $fallBackLangId
     * @return bool
     */
    public function getContact($lang, $fallBackLangId = null){
        $language = Language::select('id')->where('short', '=', $lang)->first();
        if (isset($language)){
            $language = $language->id;
        } else {
            $language = 1;
        }
        $contact = $this->select()->where('language_id', '=', $language)->first();
        if (isset($contact)){
            return $contact;
        } else {
            if ($fallBackLangId != null) {
                $fallback_contact = $this->select()->where('language_id', '=', $this->fallBackLangId)->first();
                return $fallback_contact;
            } else {
                return false;
            }
        }
    }


    /**
     * @param $lang
     * @param Contact|null $contact
     * @param ContactRequest $request
     * @return Contact
     */
    public function setContact($lang, Contact $contact=null, ContactRequest $request){
        $lang_id = Language::getLanguageId($lang);
        if (isset($contact)){
            $contact->fill([
                'tell' => $request->tell,
                'email' => $request->email,
                'fb' => $request->fb,
                'tw' => $request->tw,
                'yt' => $request->yt,
                'ig' => $request->ig,
                'li' => $request->li,
                'gh' => $request->gh,
                'tg' => $request->tg,
                'gp' => $request->gp,
                'pn' => $request->pn,
                'user_id' => Auth::user()->id,
            ])->save();
            return $contact;
        } else {
            $contactId = Contact::insertGetId([
                'language_id' => $lang_id,
                'user_id' => Auth::user()->id,
                'tell' => $request->tell,
                'email' => $request->email,
                'fb' => $request->fb,
                'tw' => $request->tw,
                'yt' => $request->yt,
                'ig' => $request->ig,
                'li' => $request->li,
                'gh' => $request->gh,
                'tg' => $request->tg,
                'gp' => $request->gp,
                'pn' => $request->pn,
            ]);
            $contact = $this->select()->where('id', '=', $contactId)->first();

            return $contact;
        }
    }




    /**
     * @param $lang
     * @param int $fallBackLang
     * @return mixed
     */
    public static function getTell($lang, $fallBackLang=1){
        $language = Language::select('id')
            ->where('short', '=', $lang)->first();
        if (isset($language)){
            $language = $language->id;
        } else {
            $language = $fallBackLang;
        }

        $contact = Contact::select('tell')->where('language_id', '=', $language)->first();
        if (isset($contact)){
            return $contact;
        } else {
            return false;
        }
    }


    /**
     * @param $lang
     * @param int $fallBackLang
     * @return mixed
     */
    public static function getEmail($lang, $fallBackLang=1){
        $language = Language::select('id')
            ->where('short', '=', $lang)->first();
        if (isset($language)){
            $language = $language->id;
        } else {
            $language = $fallBackLang;
        }

        $contact =  Contact::select('email')->where('language_id', '=', $language)->first();
        if (isset($contact)){
            return $contact;
        } else {
            return false;
        }
    }





    /**
     * @param $lang
     * @param int $fallBackLang
     * @return mixed
     */
    public static function getSocial($lang, $fallBackLang=1){
        $language = Language::select('id')
            ->where('short', '=', $lang)->first();
        if (isset($language)){
            $language = $language->id;
        } else {
            $language = $fallBackLang;
        }

        $contact =  Contact::select()->where('language_id', '=', $language)->first();
        if (isset($contact)){
            return $contact;
        } else {
            return false;
        }
    }




}
