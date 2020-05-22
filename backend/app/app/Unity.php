<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unity extends Model
{
    protected $table = 'unity';
    protected $primaryKey = 'ID';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
