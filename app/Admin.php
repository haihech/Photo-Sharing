<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $fillable = [
		'id', 'password', 'name', 'created_at', 'updated_at'
	];

	
}