<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserLike;
use App\UserSave;
use Auth;
class Post extends Model
{
    protected $table = 'post';
    protected $fillable = [
        'id', 'users_id', 'category_id','title','views', 'img', 'status', 'source', 'created_at', 'updated_at'
    ];
    public function user(){
    	return $this->belongsTo('App\User','users_id');
    }
    public function likes(){
    	return $this->hasMany('App\UserLike');
    }
    public function countLikes(){
    	return count($this->likes);
    }
    public function comments(){
    	return $this->hasMany('App\UserComment')->where('index',1);
    }
    public function countComments(){
    	return count($this->comments);
    }
    public function commentsDESC(){
    	return $this->comments->sortByDESC('created_at');
    }
    public function getYear(){
    	$date=date_create($this->created_at);
    	return date_format($date,"Y");
    }
    public function getMonth(){
    	$date=date_create($this->created_at);
    	return date_format($date,"m");
    }
    public function getDay(){
    	$date=date_create($this->created_at);
    	return date_format($date,"d");
    }
    public function isLike(){
    	if(!Auth::check()) return null;
    	return UserLike::where('users_id',Auth::user()->id)->where('post_id',$this->id)->first();
    }
    public function isSave(){
    	if(!Auth::check()) return null;
    	return UserSave::where('users_id',Auth::user()->id)->where('post_id',$this->id)->first();
    }
    public function isReport(){
    	return $this->hasMany('App\Report')->count();
    }
}
