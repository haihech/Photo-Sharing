<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSubComment extends Model
{
    protected $table = 'users_subcomments';
    protected $fillable = [
		'id', 'users_subcomments_id', 'users_comments_id','created_at', 'updated_at'
	];
}
