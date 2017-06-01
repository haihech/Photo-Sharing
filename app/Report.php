<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'report';
    protected $fillable = [
		'id', 'users_id', 'post_id','type','reason','status', 'created_at', 'updated_at'
	];
}
