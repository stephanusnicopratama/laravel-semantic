<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class transaction_temp extends Model
{
    protected function getTempSales()
    {
        return DB::table('transaction_temp')->get();
    }

    protected function insertTempSales($data)
    {
        return DB::table('transaction_temp')->insert([
            'transaction_code' => $data['transaction_code'],
            'item_code' => $data['item_code'],
            'item_name' => $data['item_name'],
            'qty' => $data['qty'],
            'price' => $data['price'],
            'user' => $data['user'],
        ]);
    }

    protected function deleteTempSales($id)
    {
        return DB::table('transaction_temp')->where('id', $id)->delete();
    }

    protected function getOneTempSales($id)
    {
        return DB::table('transaction_temp')->where('id', $id)->get();
    }

    protected function emptyTempSales()
    {
        return DB::table('transaction_temp')->delete();
    }
}
