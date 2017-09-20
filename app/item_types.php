<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class item_types extends Model
{
    protected $fillable = [
        'name_type'
    ];

    protected function deleteItemTypes($id) {
        $status = DB::table('item_types')->where('id_type', $id)->delete();
        return $status;
    }

    protected function getOneData($column, $data) {
        return DB::table('item_types')->where($column, $data)->get();
    }

    protected function updateData($column, $data) {
        return DB::table('item_types')->where($column, $data)->get();
    }
}
