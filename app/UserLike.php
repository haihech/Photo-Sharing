<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLike extends Model
{
    protected $table = 'user_like';
    protected $fillable = [
		'id', 'users_id', 'post_id','type','created_at', 'updated_at'
	];
}
