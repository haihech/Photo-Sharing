<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserLikeComment;
use Auth;
class UserComment extends Model
{
    protected $table='users_comments';
    protected $fillable = [
        'users_id','post_id', 'comment','index'
    ];
    public function subIdComments(){
    	return $this->hasMany('App\UserSubComment','users_comments_id')->pluck('users_subcomments_id');
    }
    public function subComments($index,$nums){
    	return $this->whereIn('id',$this->subIdComments()->toArray())->orderBy('created_at','DESC')->skip($index)->take($nums)->get();
    }
    public function user(){
    	return $this->belongsTo('App\User','users_id');
    }
    public function likes(){
    	return $this->hasMany('App\UserLikeComment','users_comments_id')->count();
    }
    public function isLike(){
    	return UserLikeComment::where('users_id',Auth::user()->id)->where('users_comments_id',$this->id)->first();
    }
}
