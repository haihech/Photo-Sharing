<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use Notifiable;

    protected $table='users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_fb','nickname','username', 'email', 'password','avatar','status', 'created_at', 'updated_at', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function postAll(){
        return $this->hasMany('App\Post','users_id');
    }
    public function postTC(){
        return $this->hasMany('App\Post','users_id')->where('status',2)->count();
    }
    public function postKTC(){
        return $this->hasMany('App\Post','users_id')->where('status',3)->count();
    }
    public function postBC(){
        return $this->hasMany('App\Post','users_id')->where('status',1)->count();
    }
    public function postPD(){
        return $this->hasMany('App\Post','users_id')->where('status',0)->count();
    }
    public function totalLike(){
        $posts=$this->postAll;
        $count=0;
        foreach($posts as $p) {
            $count+=$p->countLikes();
        }
        return $count;
    }
    public function totalReport(){
        $posts=$this->postAll;
        $count=0;
        foreach($posts as $p) {
            if($p->isReport()) $count++;
        }
        return $count;
    }
}
