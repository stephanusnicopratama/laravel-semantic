<?php

namespace App\Http\Controllers;

use App\Item;
use App\sales_detail;
use App\sales_master;
use App\transaction_temp;
use Carbon\Carbon;
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
            return json_encode(array(array('item_name' => '', 'price' => '', 'selling_price' => '')));
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
        $param = array(
            'transaction_code' => $transaction_code,
            'item_code' => $item_code,
            'item_name' => $item_name,
            'qty' => $qty,
            'price' => $price,
            'user' => $user,
        );
        $exec = transaction_temp::insertTempSales($param);
        if ($exec) {
            $data = Item::getEditData($item_code);
            $qty_result = $data[0]->item_stock - $qty;
            $result = Item::updateQty($item_code, $qty_result);
        }
        return json_encode($result);
    }

    public function deleteCart(Request $request)
    {
        $data = explode('|', $request->input('id'));
        $id = $data[0];
        $code = $data[1];
        $qty = $data[2];
        $dataItem = Item::getEditData($code);
        $delete = transaction_temp::deleteTempSales($id);
        if ($delete) {
            $qtyResult = $dataItem[0]->item_stock + $qty;
            $result = Item::updateQty($code, $qtyResult);
        }
        return json_encode($result);
    }

    public function getEditCart(Request $request)
    {
        $id = $request->input('id');
        $data = transaction_temp::getOneTempSales($id);
        return json_encode($data);
    }

    public function updateCart(Request $request)
    {
        $id = $request->input('id_detail');
        $transaction_code = $request->input('salesCode');
        $item_code = $request->input('itemCode');
        $item_name = $request->input('itemName');
        $qty = $request->input('qty');
        $price = $request->input('price');
        $user = Auth::user()->username;
        $param = array(
            'transaction_code' => $transaction_code,
            'item_code' => $item_code,
            'item_name' => $item_name,
            'qty' => $qty,
            'price' => $price,
            'user' => $user,
        );
        return json_encode($id);
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

    public function getMasterTransaction()
    {
        $data = sales_master::getAllSalesMaster();
        return json_encode(array('data' => $data));
    }

    public function getRangeMasterTransaction(Request $request)
    {
        $date1 = $request->input('rangestart');
        $date2 = $request->input('rangeend');
        $param = array(date('Y-m-d', strtotime($date1)), date('Y-m-d', strtotime($date2)));
        $data = sales_master::getRangeSalesMaster($param);
        return json_encode(array('data' => $data));
    }

    public function getListDetailTransaction(Request $request)
    {
        $code = $request->input('code');
        $data = sales_master::getListDetailTransaction($code);
        return json_encode(array('data' => $data));
    }

    public function totalSalesChart()
    {
        $currentDate = Carbon::now();
        $currentMonth = $currentDate->month;
        $currentYear = $currentDate->year;
        $data = sales_master::getChartCurrent($currentMonth, $currentYear);
        return json_encode($data);
    }
}
