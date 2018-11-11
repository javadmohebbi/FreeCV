<?php

/**
 * @param $strDate -> Gregorian Date time
 * @return mixed -> Jalali date
 */
function toJalali($strDate, $strFormat='Y-m-d'){
    return \Morilog\Jalali\Facades\jDateTime::strftime($strFormat, strtotime($strDate));
}


/**
 * @return true -> If user has admin role
 */
function checkIfAdmin(){
    if (Auth::check()){
        if (auth()->user()->is_admin == 1){
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * @return string -> First name and Last name
 */
function getUsername(){
    $userId = auth()->user()->id;
    if (isset($userId)) {
        return \App\UserInformation::getUsername($userId);
    } else {
        return null;
    }

}


/**
 * @return \App\Bio|mixed
 */
function getBio(){
    $bio = new \App\Bio();
    $bio = $bio->getBio(App::getLocale());
    return $bio;
}

/**
 * @return string of Bio Image
 */
function getBioImage(){
    $bioImage = \App\Image::select()->where('id', '=', 99)->first()->path;
    return asset('public/img/' . $bioImage);
}

/**
 * @return -> All Project or False
 */
function getProjects(){
    $projects = new \App\Project();
    return $projects->getAll(App::getLocale());
}

/**
 * @return null -> All articles or False
 */
function getBlogs(){
    $articles = new \App\Article();
    //return $articles->getAll(App::getLocale());
    return $articles->getPaginate(App::getLocale(),1);
}

function getBlogImage($imageId){
    if ($imageId != null) {
        $image = \App\Image::select('path')
            ->where('id', '=', $imageId)
            ->first()->path;

        return url('public/img/articles/' . $image);
    } else {
        return null;
    }

}


/**
 * @return null
 */
function getUnreadComments(){
    $comments = new \App\Comment();
    return $comments->getUnreadComments();
}

/**
 * @param $articleId
 * @return mixed
 */
function getApprovedComments($articleId){
    $comments = new \App\Comment();
    return $comments->getApprovedComments($articleId);
}

function getMostUsedTags(){
    $tags = new \App\Tag();
    return $tags->getMostUsedTags();
}



/**
 * @param $commentid
 * @return mixed
 */
function getCommenterName($commentid){
    $comments = new \App\Comment();
    return $comments->getCommenterName($commentid);
}

/**
 * @param $commentid
 * @return mixed
 */
function getCommenterEmail($commentid){
    $comments = new \App\Comment();
    return $comments->getCommenterEmail($commentid);
}

/**
 * @param $date
 * @return string
 */
function getHumanReadableDateTime($date){
    $settings = new \App\Setting();
    return $settings->getHumanReadableDateTime($date, App::getLocale());
}




/**
 * @param $date
 * @return string
 */
function getBlogDate($date){
    $setting = new \App\Setting();
    return $setting->getHumanReadableDateTime($date, App::getLocale());
}

/**
 * @param $blogId
 * @return int
 */
function getBlogCommentCounts($blogId){
    $comments = \App\Comment::select()->where('article_id', '=', $blogId)->get();
    return count($comments);
}

/**
 * @param $blogId
 * @return int
 */
function getBlogViewCount($blogId){
    $article = new \App\Article();
    return $article->getArticleViewCount($blogId);
}

/**
 * @param $blogId
 * @return mixed
 */
function getBlogTags($blogId) {
    $tags = new \App\Tag();
    return $tags->getTagsBelongsToBlog($blogId);
}

/**
 * @return -> All Education and Experiences or False
 */
function getExperiences(){
    $experiences = new \App\Experience();
    return $experiences->getAll(App::getLocale());
}

/**
 * @return -> All Skills
 */
function getSkills(){
    $skills = new \App\Skill();
    return $skills->getAll(App::getLocale());
}

function getColorCssClass($color){
    return \App\Skill::getColor($color);
}


/**
 * @param $isPresent
 * @return bool -> True = Yes, False = No
 */
function getBadge($isPresent){
   return \App\Project::getBadge($isPresent);
}

/**
 * @param $month
 * @return \Illuminate\Contracts\Translation\Translator|string
 */
function getMonthName($month){
    return \App\Project::getMonth($month);
}


/**
 * @return mixed -> get Tell
 */
function getContactTell(){
    return \App\Contact::getTell(App::getLocale());
}


/**
 * @return mixed -> get Email
 */
function getContactEmail(){
    return \App\Contact::getEmail(App::getLocale());
}

/**
 * @return mixed
 */
function getSocial() {
    return \App\Contact::getSocial(App::getLocale());
}






/** get enable disable bio */
function getEnabledBio($lang){
    $setting = new \App\Setting();
    $html = '';
    if ($setting->getIsBioEnabled($lang) == true) {
        $html .= '<a id="btnEnDiBio" data="1" href="javascript:void(0);">';
        $html .= '  <i class="menu-icon fa fa-question-circle bg-red">';
        $html .= '      <img class="loading hidden" src="'.asset('public/img/ajax-loader-spin.gif').'" alt="loading"/>';
        $html .= '  </i>';
        $html .= '  <div class="menu-info">';
        $html .= '    <h4 class="control-sidebar-subheading">'.  trans('ocv.bio_and_about_me') .'</h4>';
        $html .= '    <p>' . trans('ocv.is_enabled') . ' ' . trans('ocv.click_to_disable')  . '</p>';
        $html .= '  </div>';
        $html .= '</a>';
    } else {
        $html .= '<a id="btnEnDiBio" data="2" href="javascript:void(0);">';
        $html .= '  <i class="menu-icon fa fa-question-circle bg-gray">';
        $html .= '      <img class="loading hidden" src="'.asset('public/img/ajax-loader-spin.gif').'" alt="loading"/>';
        $html .= '  </i>';
        $html .= '  <div class="menu-info">';
        $html .= '    <h4 class="control-sidebar-subheading">'.  trans('ocv.bio_and_about_me') .'</h4>';
        $html .= '    <p>' . trans('ocv.is_disabled') . ' ' . trans('ocv.click_to_enable')  . '</p>';
        $html .= '  </div>';
        $html .= '</a>';
    }
    return $html;
}

/** Is Bio Active */
function isBioActive($lang){
    $setting = new \App\Setting();
    if (\App\User::isAdmin()) {
        return true;
    } else {
        $setting = $setting->getIsBioEnabled($lang);
        if ($setting == true) {
            return true;
        } else {
            return false;
        }

    }
}


/** get enable disable project */
function getEnabledProject($lang){
    $setting = new \App\Setting();
    $html = '';
    if ($setting->getIsProjectEnabled($lang) == true) {
        $html .= '<a id="btnEnDiProject" data="1" href="javascript:void(0);">';
        $html .= '  <i class="menu-icon fa fa-cubes bg-red">';
        $html .= '      <img class="loading hidden" src="'.asset('public/img/ajax-loader-spin.gif').'" alt="loading"/>';
        $html .= '  </i>';
        $html .= '  <div class="menu-info">';
        $html .= '    <h4 class="control-sidebar-subheading">'.  trans('ocv.projects') .'</h4>';
        $html .= '    <p>' . trans('ocv.is_enabled') . ' ' . trans('ocv.click_to_disable')  . '</p>';
        $html .= '  </div>';
        $html .= '</a>';
    } else {
        $html .= '<a id="btnEnDiProject" data="2" href="javascript:void(0);">';
        $html .= '  <i class="menu-icon fa fa-cubes bg-gray">';
        $html .= '      <img class="loading hidden" src="'.asset('public/img/ajax-loader-spin.gif').'" alt="loading"/>';
        $html .= '  </i>';
        $html .= '  <div class="menu-info">';
        $html .= '    <h4 class="control-sidebar-subheading">'.  trans('ocv.projects') .'</h4>';
        $html .= '    <p>' . trans('ocv.is_disabled') . ' ' . trans('ocv.click_to_enable')  . '</p>';
        $html .= '  </div>';
        $html .= '</a>';
    }
    return $html;
}

/** Is Project Active */
function isProjectActive($lang){
    $setting = new \App\Setting();
    if (\App\User::isAdmin()) {
        return true;
    } else {
        $setting = $setting->getIsProjectEnabled($lang);
        if ($setting == true) {
            return true;
        } else {
            return false;
        }

    }
}

/** get enable disable skill */
function getEnabledSkill($lang){
    $setting = new \App\Setting();
    $html = '';
    if ($setting->getIsSkillEnabled($lang) == true) {
        $html .= '<a id="btnEnDiSkill" data="1" href="javascript:void(0);">';
        $html .= '  <i class="menu-icon fa fa-check-square bg-red">';
        $html .= '      <img class="loading hidden" src="'.asset('public/img/ajax-loader-spin.gif').'" alt="loading"/>';
        $html .= '  </i>';
        $html .= '  <div class="menu-info">';
        $html .= '    <h4 class="control-sidebar-subheading">'.  trans('ocv.skill') .'</h4>';
        $html .= '    <p>' . trans('ocv.is_enabled') . ' ' . trans('ocv.click_to_disable')  . '</p>';
        $html .= '  </div>';
        $html .= '</a>';
    } else {
        $html .= '<a id="btnEnDiSkill" data="2" href="javascript:void(0);">';
        $html .= '  <i class="menu-icon fa fa-check-square bg-gray">';
        $html .= '      <img class="loading hidden" src="'.asset('public/img/ajax-loader-spin.gif').'" alt="loading"/>';
        $html .= '  </i>';
        $html .= '  <div class="menu-info">';
        $html .= '    <h4 class="control-sidebar-subheading">'.  trans('ocv.skill') .'</h4>';
        $html .= '    <p>' . trans('ocv.is_disabled') . ' ' . trans('ocv.click_to_enable')  . '</p>';
        $html .= '  </div>';
        $html .= '</a>';
    }
    return $html;
}

/** Is Skill Active */
function isSkillActive($lang){
    $setting = new \App\Setting();
    if (\App\User::isAdmin()) {
        return true;
    } else {
        $setting = $setting->getIsSkillEnabled($lang);
        if ($setting == true) {
            return true;
        } else {
            return false;
        }

    }
}

/** get enable disable Exper. & Edu. */
function getEnabledExperience($lang){
    $setting = new \App\Setting();
    $html = '';
    if ($setting->getIsExperiencesEnabled($lang) == true) {
        $html .= '<a id="btnEnDiEdu" data="1" href="javascript:void(0);">';
        $html .= '  <i class="menu-icon fa fa-mortar-board bg-red">';
        $html .= '      <img class="loading hidden" src="'.asset('public/img/ajax-loader-spin.gif').'" alt="loading"/>';
        $html .= '  </i>';
        $html .= '  <div class="menu-info">';
        $html .= '    <h4 class="control-sidebar-subheading">'.  trans('ocv.experiences_and_education') .'</h4>';
        $html .= '    <p>' . trans('ocv.is_enabled') . ' ' . trans('ocv.click_to_disable')  . '</p>';
        $html .= '  </div>';
        $html .= '</a>';
    } else {
        $html .= '<a id="btnEnDiEdu" data="2" href="javascript:void(0);">';
        $html .= '  <i class="menu-icon fa fa-mortar-board bg-gray">';
        $html .= '      <img class="loading hidden" src="'.asset('public/img/ajax-loader-spin.gif').'" alt="loading"/>';
        $html .= '  </i>';
        $html .= '  <div class="menu-info">';
        $html .= '    <h4 class="control-sidebar-subheading">'.  trans('ocv.experiences_and_education') .'</h4>';
        $html .= '    <p>' . trans('ocv.is_disabled') . ' ' . trans('ocv.click_to_enable')  . '</p>';
        $html .= '  </div>';
        $html .= '</a>';
    }
    return $html;
}

/** Is Experiences Active */
function isExperiencesActive($lang){
    $setting = new \App\Setting();
    if (\App\User::isAdmin()) {
        return true;
    } else {
        $setting = $setting->getIsExperiencesEnabled($lang);
        if ($setting == true) {
            return true;
        } else {
            return false;
        }

    }
}

/** get enable disable Contact */
function getEnabledContact($lang){
    $setting = new \App\Setting();
    $html = '';
    if ($setting->getIsContactsEnabled($lang) == true) {
        $html .= '<a id="btnEnDiContact" data="1" href="javascript:void(0);">';
        $html .= '  <i class="menu-icon fa fa-share-alt-square bg-red">';
        $html .= '      <img class="loading hidden" src="'.asset('public/img/ajax-loader-spin.gif').'" alt="loading"/>';
        $html .= '  </i>';
        $html .= '  <div class="menu-info">';
        $html .= '    <h4 class="control-sidebar-subheading">'.  trans('ocv.contact_me') .'</h4>';
        $html .= '    <p>' . trans('ocv.is_enabled') . ' ' . trans('ocv.click_to_disable')  . '</p>';
        $html .= '  </div>';
        $html .= '</a>';
    } else {
        $html .= '<a id="btnEnDiContact" data="2" href="javascript:void(0);">';
        $html .= '  <i class="menu-icon fa fa-share-alt-square bg-gray">';
        $html .= '      <img class="loading hidden" src="'.asset('public/img/ajax-loader-spin.gif').'" alt="loading"/>';
        $html .= '  </i>';
        $html .= '  <div class="menu-info">';
        $html .= '    <h4 class="control-sidebar-subheading">'.  trans('ocv.contact_me') .'</h4>';
        $html .= '    <p>' . trans('ocv.is_disabled') . ' ' . trans('ocv.click_to_enable')  . '</p>';
        $html .= '  </div>';
        $html .= '</a>';
    }
    return $html;
}

/** Is Contact Active */
function isContactActive($lang){
    $setting = new \App\Setting();
    if (\App\User::isAdmin()) {
        return true;
    } else {
        $setting = $setting->getIsContactsEnabled($lang);
        if ($setting == true) {
            return true;
        } else {
            return false;
        }

    }
}

/** get enable disable KB */
function getEnabledKb($lang){
    $setting = new \App\Setting();
    $html = '';
    if ($setting->getIsKbEnabled($lang) == true) {
        $html .= '<a id="btnEnDiKb" data="1" href="javascript:void(0);">';
        $html .= '  <i class="menu-icon fa fa-newspaper-o bg-red">';
        $html .= '      <img class="loading hidden" src="'.asset('public/img/ajax-loader-spin.gif').'" alt="loading"/>';
        $html .= '  </i>';
        $html .= '  <div class="menu-info">';
        $html .= '    <h4 class="control-sidebar-subheading">'.  trans('ocv.kb') .'</h4>';
        $html .= '    <p>' . trans('ocv.is_enabled') . ' ' . trans('ocv.click_to_disable')  . '</p>';
        $html .= '  </div>';
        $html .= '</a>';
    } else {
        $html .= '<a id="btnEnDiKb" data="2" href="javascript:void(0);">';
        $html .= '  <i class="menu-icon fa fa-newspaper-o bg-gray">';
        $html .= '      <img class="loading hidden" src="'.asset('public/img/ajax-loader-spin.gif').'" alt="loading"/>';
        $html .= '  </i>';
        $html .= '  <div class="menu-info">';
        $html .= '    <h4 class="control-sidebar-subheading">'.  trans('ocv.kb') .'</h4>';
        $html .= '    <p>' . trans('ocv.is_disabled') . ' ' . trans('ocv.click_to_enable')  . '</p>';
        $html .= '  </div>';
        $html .= '</a>';
    }
    return $html;
}

/** Is KB Active */
function isKbActive($lang){
    $setting = new \App\Setting();
    if (\App\User::isAdmin()) {
        return true;
    } else {
        $setting = $setting->getIsKbEnabled($lang);
        if ($setting == true) {
            return true;
        } else {
            return false;
        }

    }
}


/**
 * @param $lang
 */
function getWebTitle($lang, $blogTitle=null){
    $setting = new \App\Setting();
    if ($blogTitle==null) {
        return $setting->getWebTitle($lang);
    } else {
        return $setting->getWebTitle($lang) . '|' . $blogTitle;
    }

}

/**
 * @param $lang
 */
function getWebKeywords($lang){
    $setting = new \App\Setting();
    return $setting->getWebKeywords($lang);
}

/**
 * @param $lang
 */
function getWebDescription($lang){
    $setting = new \App\Setting();
    return $setting->getWebDescription($lang);
}


/**
* @param $lang
*/
function getWebMenuLong($lang){
    $setting = new \App\Setting();
    return $setting->getWebMenuLongTitle($lang);
}

/**
 * @param $lang
 */
function getWebMenuShort($lang){
    $setting = new \App\Setting();
    return $setting->getWebMenuShortTitle($lang);
}


/**
 * @param $lang
 */
function getCustomCss($lang){
    $setting = new \App\Setting();
    return $setting->getCustomCss($lang);
}


/**
 * @param $lang
 */
function getCustomJs($lang){
    $setting = new \App\Setting();
    return $setting->getCustomJs($lang);
}


/**
 * @param $lang
 */
function getGoogleAnalytics($lang){
    $setting = new \App\Setting();
    return $setting->getGoogleAnalytics($lang);
}