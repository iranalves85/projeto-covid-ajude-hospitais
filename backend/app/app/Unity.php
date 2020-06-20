<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unity extends Model
{
    protected $table = 'unity';
    protected $primaryKey = 'ID';
    protected $fillable = ['name', 'address', 'number', 'neighborhood', 'city', 'state', 'cep'];
}
