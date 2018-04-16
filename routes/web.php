<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['prefix' => LaravelLocalization::setLocale()], function() {

    Route::get('install', 'InstallationController@installWindow');
    Route::get('{local}/install', 'InstallationController@setLocal');
    Route::post('install/check/it', 'InstallationController@installApp');
    Route::get('install/check/rollback', 'InstallationController@rollback');

});





    Route::group(['prefix' => LaravelLocalization::setLocale()], function() {

        Route::group(['middleware' => ['language']], function (){

            Route::get('/', function () {
                try {
                    $language = \App\Language::get();
                    $setting = new \App\Setting();
                    return view('templates.home', compact('setting'));
                } catch (Exception $exception) {
                    return \Illuminate\Support\Facades\Response::redirectTo('/', 302);
                }
            });

            Auth::routes();



            /** Routes related to Bio & About */
            Route::post('bio/ajax/get', 'BioController@ajaxGetBio');
            Route::post('bio/ajax/set', 'BioController@ajaxSetBio');
            Route::post('image/ajax/set/bio', 'ImagesController@ajaxSetBioImage');




            /** Routes related to Projects & Activities */
            Route::bind('project_id', function($id){
                return App\Project::select('*')->where('id',$id)->first();
            });
            Route::post('project/ajax/get/{project_id}', 'ProjectsController@getProject');
            Route::post('project/ajax/new', 'ProjectsController@addNewProject');
            Route::post('project/ajax/update/{project_id}', 'ProjectsController@updateProject');
            Route::post('project/ajax/remove/{project_id}', 'ProjectsController@destroyProject');





            /** Routes related to Skills */
            Route::bind('skill_id', function($id){
                return App\Skill::select('*')->where('id',$id)->first();
            });
            Route::post('skill/ajax/get/{skill_id}', 'SkillsController@getSkill');
            Route::post('skill/ajax/new', 'SkillsController@addNewSkill');
            Route::post('skill/ajax/update/{skill_id}', 'SkillsController@updateSkill');
            Route::post('skill/ajax/remove/{skill_id}', 'SkillsController@destroySkill');





            /** Routes related to Projects & Activities */
            Route::bind('experience_id', function($id){
                return App\Experience::select('*')->where('id',$id)->first();
            });
            Route::post('edu/ajax/get/{experience_id}', 'ExperiencesController@getExperience');
            Route::post('edu/ajax/new', 'ExperiencesController@addNewExperience');
            Route::post('edu/ajax/update/{experience_id}', 'ExperiencesController@updateExperience');
            Route::post('edu/ajax/remove/{experience_id}', 'ExperiencesController@destroyExperience');




            /** Routes related to Contacts */
            Route::post('contact/ajax/get', 'ContactsController@ajaxGetContact');
            Route::post('contact/ajax/set', 'ContactsController@ajaxSetContact');




            /** Routes related to Articles */
            Route::bind('articleId', function($id){
                return App\Article::select('*')->where('id',$id)->first();
            });
            Route::bind('articleSlug', function($slug){
                $langId = new \App\Setting();
                $langId = $langId->getLangId(App::getLocale());

                return App\Article::select('*')
                    ->where('slug',$slug)
                    ->where('enabled',1)
                    ->where('language_id',$langId)->first();
            });
            Route::get('blog/{articleSlug}', 'ArticlesController@getArticle');
            Route::post('image/ajax/upload/article', 'ImagesController@ajaxUploadImage');
            Route::post('kb/ajax/new', 'ArticlesController@addNewKB');
            Route::post('kb/ajax/update/{articleId}', 'ArticlesController@updateKB');
            Route::post('kb/ajax/get/{articleId}', 'ArticlesController@getKbById');
            Route::post('image/ajax/set/article/{articleId}', 'ImagesController@ajaxSetArticleImage');
            Route::post('image/ajax/delete/article/{articleId}', 'ImagesController@ajaxDeleteArticleImage');
            Route::post('kb/ajax/disable/{articleId}', 'ArticlesController@disableKbById');
            Route::post('kb/ajax/enable/{articleId}', 'ArticlesController@enableKbById');
            Route::post('kb/ajax/delete/{articleId}', 'ArticlesController@deleteKbById');

            Route::get('/kb/ajax/load/more/', 'ArticlesController@ajaxLoadMoreArticle');



            /** Comments */
            Route::bind('commentId', function($id){
                return App\Comment::select('*')->where('id',$id)->first();
            });
            Route::get('comment/kb/{articleId}', 'CommentController@ajaxGetCommentsBelongsToKb');
            Route::get('comment/unread/', 'CommentController@ajaxGetUnreadComments');
            Route::post('comment/delete/{commentId}', 'CommentController@ajaxDeleteComment');
            Route::post('comment/hide/{commentId}', 'CommentController@ajaxHideComment');
            Route::post('comment/approve/{commentId}', 'CommentController@ajaxApproveComment');
            Route::post('comment/update/unread/', 'CommentController@ajaxUpdateUnreadComments');
            Route::get('/comment/ajax/load/more/{articleId}', 'CommentController@ajaxLoadMoreComments');
            Route::post('comment/insert/{articleId}', 'CommentController@ajaxInsertComment');

            /** TAGS */
            Route::get('tags/get', 'TagsController@getAllTags');


            /** Languages */
            Route::bind('languageId', function($id){
                return App\Language::select('*')->where('id', $id)->first();
            });
            Route::get('language/get/', 'LanguagesController@ajaxGetLanguages');
            Route::post('language/enable/{languageId}', 'LanguagesController@ajaxEnableLanguage');
            Route::post('language/disable/{languageId}', 'LanguagesController@ajaxDisableLanguage');

            /** Users */
            Route::bind('userId', function($id){
                return App\User::select('*')->where('id', $id)->first();
            });
            Route::get('user/get/', 'UsersController@ajaxGetUsers');
            Route::post('user/enable/{userId}', 'UsersController@ajaxEnableUser');
            Route::post('user/disable/{userId}', 'UsersController@ajaxDisableUser');
            Route::post('user/define/admin/{userId}', 'UsersController@ajaxDefineAsAdminUser');
            Route::post('user/define/normal/{userId}', 'UsersController@ajaxDefineAsNormalUser');



            /** Settings */
            Route::post('setting/enable/bio', 'SettingsController@ajaxEnableBio');
            Route::post('setting/disable/bio', 'SettingsController@ajaxDisableBio');

            Route::post('setting/enable/project', 'SettingsController@ajaxEnableProjects');
            Route::post('setting/disable/project', 'SettingsController@ajaxDisableProjects');

            Route::post('setting/enable/skill', 'SettingsController@ajaxEnableSkills');
            Route::post('setting/disable/skill', 'SettingsController@ajaxDisableSkills');

            Route::post('setting/enable/experience', 'SettingsController@ajaxEnableExperiences');
            Route::post('setting/disable/experience', 'SettingsController@ajaxDisableExperiences');

            Route::post('setting/enable/contact', 'SettingsController@ajaxEnableContacts');
            Route::post('setting/disable/contact', 'SettingsController@ajaxDisableContacts');

            Route::post('setting/enable/kb', 'SettingsController@ajaxEnableKb');
            Route::post('setting/disable/kb', 'SettingsController@ajaxDisableKb');


            Route::post('setting/web/info', 'SettingsController@ajaxSaveWebsiteInformation');
            Route::post('setting/web/custom', 'SettingsController@ajaxSaveWebsiteCustomization');


            /** Site Map */
            Route::get('sitemap.xml', 'SitemapController@index');
            Route::get('sitemap', 'SitemapController@index');


            /** Hashtag */
            Route::bind('hashtag', function($tag){
                return App\Tag::select('*')->where('tag', '=', $tag)->first();
            });
            Route::get('hashtag/{hashtag}', 'TagsController@getItemsBelongsToTag');


        });

        //Route::get('/home', 'HomeController@index')->name('home');

    });

