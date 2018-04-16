<?php

/**
 * @param string $lang
 * @return bool
 */
function isRTLForInstallation($lang = 'en'){
    if ($lang == 'fa' || $lang == 'ar') {
        return true;
    } else {
        return false;
    }
}




/*
 *
 * Check Local Language and return TRUE if the current language is RTL
 */
function isRTL($lang = null){
    if ($lang == null) {
        $lang = App::getLocale();
    }
    /*if ($lang == 'fa' || $lang == 'ar') {
        return true;
    } else {
        return false;
    }*/

    return \App\Language::isRTL($lang);
}

/*
 *
 *
 * Get current Language
 *
 */
function getLang(){
    return App::getLocale();
}


function getLangShortById($id){
    return \App\Language::where('id', '=', $id)->first()->short;
}


/**
 * @return \Illuminate\Database\Eloquent\Collection|static[]  Return Enabled Language Eloquent model
 */
function getAllLanguages(){
    return \App\Language::select()->where('enabled', '=', 1)
        ->get();
}


