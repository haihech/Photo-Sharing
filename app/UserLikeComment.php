<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLikeComment extends Model
{
    protected $table = 'users_like_comments';
    protected $fillable = [
		'id', 'users_id', 'users_comments_id','created_at', 'updated_at'
	];
}
