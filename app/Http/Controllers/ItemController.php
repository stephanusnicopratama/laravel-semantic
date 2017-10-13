<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function getAllData()
    {
        $data = Item::getAllData();
        return json_encode(array('data' => $data), JSON_PRETTY_PRINT);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function insertNewData(Request $request)
    {
        $code = $request->input('code');
        $itemName = $request->input('name');
        $itemType = $request->input('type_item');
        $qty = $request->input('qty');
        $pcs = $request->input('pcs');
        $selling_price = $request->input('selling_price');
        $purchase_price = $request->input('purchase_price');
        $supplier = $request->input('supplier');
        $user = Auth::user()->username;
        $param = array(
            'code' => $code,
            'itemName' => $itemName,
            'itemType' => $itemType,
            'qty' => $qty,
            'pcs' => $pcs,
            'selling_price' => $selling_price,
            'purchase_price' => $purchase_price,
            'supplier' => $supplier,
            'user' => $user
        );
        $status = Item::insertNewData($param);
        return json_encode($status);
    }

    public function deleteData(Request $request)
    {
        $code = $request->input('code');
        $status = Item::deleteData($code);
        return json_encode($status);
    }

    public function editData(Request $request)
    {
        $code = $request->input('code');
        $itemName = $request->input('name');
        $itemType = $request->input('type_item');
        $selling_price = $request->input('selling_price');
        $purchase_price = $request->input('purchase_price');
        $qty = $request->input('qty');
        $pcs = $request->input('pcs');
        $supplier = $request->input('supplier');
        $user = Auth::user()->username;
        $param = array(
            'code' => $code,
            'itemName' => $itemName,
            'itemType' => $itemType,
            'qty' => $qty,
            'pcs' => $pcs,
            'selling_price' => $selling_price,
            'purchase_price' => $purchase_price,
            'supplier' => $supplier,
            'user' => $user
        );
        $status = Item::editData($param);
        return json_encode($param);
    }

    public function getEditData(Request $request)
    {
        $code = $request->input('code');
        $data = Item::getEditData($code);
        return json_encode($data[0]);
    }

    public function checkCodeItem(Request $request)
    {
        $code = $request->input('code');
        $data = Item::getEditData($code);
        if (count($data) > 0) {
            $status = false;
        } else {
            $status = true;
        }
        return json_encode($status);
    }

    public function checkQty(Request $request)
    {
        $code = $request->input('code');
        $qty = $request->input('qty');
        $data = Item::getEditData($code);
        $result = $data[0]->item_stock - $qty;
        if ($result < 0) {
            $status = false;
        } else {
            $status = true;
        }
        return json_encode($status);
    }

    public function checkQtyUpdate(Request $request)
    {
        $code = $request->input('code');
        $oldQty = $request->input('old_qty');
        $qty = $request->input('qty');
        $data = Item::getEditData($code);
        $result = ($data[0]->item_stock + $oldQty) - $qty;
        if ($result < 0) {
            $status = false;
        } else {
            $status = true;
        }
        return json_encode($status);
    }

}
