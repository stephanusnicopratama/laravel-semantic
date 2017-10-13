<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class sales_master extends Model
{
    protected function insertSalesMaster()
    {
        $exec = DB::select("insert into transaction_master(transaction_code, total, user) select transaction_code, sum(qty * price), user from transaction_temp");
        return true;
    }

    protected function getAllSalesMaster()
    {
        return DB::table('transaction_master')->get();
    }

    protected function getRangeSalesMaster($date)
    {
        return DB::table('transaction_master')
            ->whereBetween(DB::raw('CAST(date as date)'), $date)
            ->get();
    }

    protected function getListDetailTransaction($code)
    {
        return DB::table('transaction_detail')
            ->where('transaction_code', $code)
            ->get();
    }

    protected function getChartCurrent($currentMonth, $currentYear)
    {
        return DB::table('transaction_master')
            ->select(DB::raw('SUM(transaction_detail.qty) as Total, item_name, date'))
            ->leftJoin('transaction_detail', 'transaction_master.transaction_code', '=', 'transaction_detail.transaction_code')
            ->leftJoin('items', 'transaction_detail.item_code', '=', 'items.item_code')
            ->whereRaw('MONTH(date) = ? AND YEAR(date) = ?', [$currentMonth, $currentYear])
            ->groupBy('transaction_detail.item_code')
            ->get();
    }
}
