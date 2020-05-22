<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    protected $table = 'resources';
    protected $primaryKey = 'ID';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
