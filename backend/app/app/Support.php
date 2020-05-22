<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $table = 'support';
    protected $primaryKey = 'ID';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
