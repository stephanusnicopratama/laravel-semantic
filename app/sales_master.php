<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class sales_master extends Model
{
    protected function insertSalesMaster()
    {
        $exec = DB::select("insert into transaction_master(transaction_code, total, user) select transaction_code, sum(price), user from transaction_temp");
        return true;
    }

    protected function getAllSalesMaster() {
        return DB::table('transaction_master')->get();
    }

    protected function getRangeSalesMaster($date) {
        return DB::table('transaction_master')
            ->whereBetween(DB::raw('CAST(date as date)'), $date)
            ->get();
    }

    protected function getListDetailTransaction($code) {
        return DB::table('transaction_detail')
            ->where('transaction_code', $code)
            ->get();
    }
}
