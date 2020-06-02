<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';
    protected $primaryKey = 'ID';
    public $timestamps = true;

}
