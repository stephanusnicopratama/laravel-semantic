<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected function insertNewData($data)
    {
        return DB::table('items')->insert([
            'item_code' => $data['code'],
            'item_name' => $data['itemName'],
            'item_stock' => $data['qty'],
            'item_type' => $data['itemType'],
            'piece' => $data['pcs'],
            'user' => $data['user'],
            'supplier' => $data['supplier']
        ]);
    }

    protected function editData($data)
    {
        return DB::table('items')->where('item_code', $data['code'])->update([
            'item_name' => $data['itemName'],
            'item_stock' => $data['qty'],
            'item_type' => $data['itemType'],
            'piece' => $data['pcs'],
            'user' => $data['user'],
            'supplier' => $data['supplier']
        ]);
    }

    protected function getAllData()
    {
        return DB::table('items')
            ->join('item_types', 'id_type', '=', 'item_type')
            ->join('suppliers', 'id_supplier', '=', 'supplier')
            ->orderBy('item_code', 'asc')
            ->get();
    }

    protected function getEditData($code)
    {
        return DB::table('items')->where('item_code', $code)->get();
    }

    protected function deleteData($code)
    {
        return DB::table('items')->where('item_code', $code)->delete();
    }
}
