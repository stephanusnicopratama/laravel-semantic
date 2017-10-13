<?php

namespace App\Http\Controllers;

use App\purchasing;
use Illuminate\Http\Request;

use App\Http\Requests;

class PurchaseController extends Controller
{
    public function getAllPurchase()
    {
        $data = purchasing::all();
        return json_encode(array('data' => $data));
    }

    public function insertPurchase(Request $request)
    {
        $item = $request->input('item');
        $qty = $request->input('qty');
        $price = $request->input('price');
        $supplier = $request->input('supplier');
        $notes = $request->input('notes');
        $param = array(
            'qty' => $qty, 'price' => $price, 'item_code' => $item, 'id_supplier' => $supplier, 'notes' => $notes
        );
        $exec = purchasing::insert($param);
        return json_encode($exec);

    }
}
