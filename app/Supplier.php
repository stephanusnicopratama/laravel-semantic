<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Supplier extends Model
{
    protected $fillable = [
        'name_supplier', 'address_supplier', 'telephone_supplier'
    ];

    protected function insertSupplier($data) {
        return DB::table('suppliers')->insert([
            'name_supplier' => $data['name'],
            'address_supplier' => $data['address'],
            'telephone_supplier' => $data['telephone']
        ]);
    }

    protected function deleteSupplier($id) {
        return DB::table('suppliers')->where('id_supplier', $id)->delete();
    }

}
