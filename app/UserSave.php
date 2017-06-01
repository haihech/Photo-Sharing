<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSave extends Model
{
    protected $table='user_save';
    protected $fillable = [
        'users_id','post_id',
    ];
}
