<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table = 'business';
    protected $primaryKey = 'ID';
    protected $fillable = ['name', 'logo', 'site', 'email'];
}
