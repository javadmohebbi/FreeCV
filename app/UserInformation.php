<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserInformation
 *
 * @mixin \Eloquent
 */
class UserInformation extends Model
{
    protected $table = 'user_information';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language_id', 'user_id', 'image_id', 'first_name', 'last_name',
        'tell', 'mobile', 'gender'
    ];


    /**
     * @param $id
     * @return string
     */
    public static function getUsername($id){
        $user = UserInformation::select()->where('user_id', '=', $id)
            ->first();
        if (isset($user)) {
            return $user->first_name . ' ' . $user->last_name;
        } else {
            return auth()->user()->name;
        }
    }

}
