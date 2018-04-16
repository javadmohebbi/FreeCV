<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Language;
use Illuminate\Support\Facades\Response;
use App\User;

class ContactsController extends Controller
{
    protected $contact;
    protected $lang;

    function __construct(Contact $contact) {
        $this->contact = $contact;
        $this->lang = App::getLocale();
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxGetContact(){
        if(User::isAdmin()) {
            $contact = $this->contact->getContact($this->lang);
            if ($contact != false) {
                return Response::json([
                    'id' => $contact->id,
                    'email' => (isset($contact->email) ? $contact->email : null),
                    'tell' => (isset($contact->tell) ? $contact->tell : null),
                    'fb' => (isset($contact->fb) ? $contact->fb : null),
                    'tw' => (isset($contact->tw) ? $contact->tw : null),
                    'yt' => (isset($contact->yt) ? $contact->yt : null),
                    'ig' => (isset($contact->ig) ? $contact->ig : null),
                    'li' => (isset($contact->li) ? $contact->li : null),
                    'gh' => (isset($contact->gh) ? $contact->gh : null),
                    'tg' => (isset($contact->tg) ? $contact->tg : null),
                    'gp' => (isset($contact->gp) ? $contact->gp : null),
                    'pn' => (isset($contact->pn) ? $contact->pn : null),
                ], 200);
            } else {
                return Response::json([
                    'id' => null,
                    'email' => null,
                    'tell' => null,
                    'fb' => null,
                    'tw' => null,
                    'yt' => null,
                    'ig' => null,
                    'li' => null,
                    'gh' => null,
                    'tg' => null,
                    'gp' => null,
                    'pn' => null,
                ], 200);
            }
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }

    }



    function ajaxSetContact(ContactRequest $request){
        if(User::isAdmin()){
            $langId = Language::getLanguageId($this->lang);
            $savedContact = null;
            if ($request->id != null) {
                $contact = Contact::select()->where('id', $request->id)->first();
                $savedContact = $contact;
            } else {
                $contact = null;
            }
            $savedContact = $this->contact->setContact($this->lang, $contact, $request);

            return Response::json([
                'id' => $savedContact->id,
                'email' => (isset($savedContact->email) ? $savedContact->email : null),
                'tell' => (isset($savedContact->tell) ? $savedContact->tell : null),
                'fb' => (isset($savedContact->fb) ? $savedContact->fb : null),
                'tw' => (isset($savedContact->tw) ? $savedContact->tw : null),
                'yt' => (isset($savedContact->yt) ? $savedContact->yt : null),
                'ig' => (isset($savedContact->ig) ? $savedContact->ig : null),
                'li' => (isset($savedContact->li) ? $savedContact->li : null),
                'gh' => (isset($savedContact->gh) ? $savedContact->gh : null),
                'tg' => (isset($savedContact->tg) ? $savedContact->tg : null),
                'gp' => (isset($savedContact->gp) ? $savedContact->gp : null),
                'pn' => (isset($savedContact->pn) ? $savedContact->pn : null),
            ], 200);
        } else {
            return Response::json([
                'error' => true,
                'msg' => trans('ocv.msg_error_auth_403')
            ], 403);
        }


    }





}
