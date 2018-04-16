<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language_id', 'user_id', 'name', 'email',
        'comments', 'parent_id', 'status', 'article_id',
    ];


    /**
     * @return null
     */
    public function getUnreadComments(){
        if (User::isAdmin()){
            return $this->select()
                ->where('status', '=', 0)
                ->get();
        } else {
            return null;
        }
    }


    /**
     * @return mixed
     */
    public function getApprovedComments($articleId){
        return $this->select()
            ->where('article_id', '=', $articleId)
            ->where('status', '=', 2)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

    }

    /**
     * @param $commentId
     * @return mixed
     */
    public function getCommenterName($commentId){
        $comment = $this->select()
            ->where('id', '=', $commentId)
            ->first();
        if ($comment->user_id != null) {
            return User::select()
                ->where('id', '=', $comment->user_id)
                ->first()->name;
        } else {
            return $comment->name;
        }

    }

    public function getCommenterEmail($commentId){
        $comment = $this->select()
            ->where('id', '=', $commentId)
            ->first();
        if ($comment->user_id != null) {
            return User::select()
                ->where('id', '=', $comment->user_id)
                ->first()->email;
        } else {
            return $comment->email;
        }

    }


}
