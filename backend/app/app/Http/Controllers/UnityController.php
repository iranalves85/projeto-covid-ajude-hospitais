<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnityController extends Controller
{
    function get(Request $request) {
        return DB::select('select * from unity');
    }

}
