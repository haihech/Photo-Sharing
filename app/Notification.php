<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = [
		'id', 'users_id', 'check','message','type', 'link', 'created_at', 'updated_at'
	];
}
