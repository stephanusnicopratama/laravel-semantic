<?php

namespace App\Http\Controllers;

use App\Item;
use App\sales_detail;
use App\sales_master;
use App\transaction_temp;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mockery\Exception;

class SalesController extends Controller
{
    public function autoNumberSales()
    {
        $code_begin = 'SLS' . date('ym');
        $checkNum = DB::table('transaction_master')
            ->where('transaction_code', 'LIKE', $code_begin . '%')->get();
        if (count($checkNum) === 0) {
            $code_end = 'SLS' . date('ym') . '0001';
        } else {
            foreach ($checkNum as $value) {
                $number = substr($value->transaction_code, 7, 4);
                $PlusNumber = (int)$number + 1;
                $code_end = 'SLS' . date('ym') . substr($number, 0, (strlen($number) - strlen($PlusNumber))) . $PlusNumber;
            }
        }
        return json_encode(array('code' => $code_end));
    }

    public function getAllItem()
    {
        $data = Item::all();
        return json_encode($data);
    }

    public function getItem(Request $request)
    {
        $code = $request->input('code');
        $data = Item::getEditData($code);
        if (count($data) > 0) {
            return json_encode($data);
        } else {
            return json_encode(array(array('item_name' => '', 'price' => '')));
        }
    }

    public function getCart()
    {
        $data = transaction_temp::getTempSales();
        return json_encode(array('data' => $data));
    }

    public function insertCart(Request $request)
    {
        $transaction_code = $request->input('salesCode');
        $item_code = $request->input('itemCode');
        $item_name = $request->input('itemName');
        $qty = $request->input('qty');
        $price = $request->input('price');
        $user = Auth::user()->username;
        $data = array(
            'transaction_code' => $transaction_code,
            'item_code' => $item_code,
            'item_name' => $item_name,
            'qty' => $qty,
            'price' => $price,
            'user' => $user,
        );
        $exec = transaction_temp::insertTempSales($data);
        return json_encode($exec);
    }

    public function deleteCart(Request $request)
    {
        $id = $request->input('id');
        $delete = transaction_temp::deleteTempSales($id);
        return json_encode($delete);
    }

    public function getEditCart(Request $request)
    {
        $id = $request->input('id');
        $data = transaction_temp::getOneTempSales($id);
        return json_encode($data);
    }

    public function insertDetailTransaction()
    {
        $data = sales_detail::insertSalesDetail();
        return json_encode($data);
    }

    public function insertMasterTransaction()
    {
        $data = sales_master::insertSalesMaster();
        return json_encode($data);
    }

    public function insertTransaction()
    {
        DB::beginTransaction();
        try {
            $master = sales_master::insertSalesMaster();
            if ($master) {
                $detail = sales_detail::insertSalesDetail();
                if ($detail) {
                    transaction_temp::emptyTempSales();
                    $status = 'OK';
                }
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
        }
        return json_encode($status);
    }
}
