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
        return DB::table('transaction_temp')->insert($data);
    }

    protected function updateTempSales($id, $data)
    {
        return DB::table('transaction_temp')->where('id', $id)->update($data);
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
