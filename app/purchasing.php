<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class purchasing extends Model
{
    protected $table = 'purchasing';

    protected function insert($data)
    {
        return DB::table('purchasing')->insert($data);
    }
}
