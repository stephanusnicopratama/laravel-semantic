<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class sales_detail extends Model
{
    protected function insertSalesDetail()
    {
        $exec = DB::select('insert into transaction_detail(transaction_code, item_code, qty, price) select transaction_code, item_code, qty, price from transaction_temp');
        return true;
    }
}
