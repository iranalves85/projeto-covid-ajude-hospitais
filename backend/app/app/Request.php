<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';
    protected $primaryKey = 'ID';
    protected $fillable = ['unity_id', 'token'];

}
