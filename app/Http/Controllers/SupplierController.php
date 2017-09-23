<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;

use App\Http\Requests;

class SupplierController extends Controller
{
    public function insertNewData(Request $request)
    {
        $name = $request->input('name');
        $address = $request->input('address');
        $telephone = $request->input('telephone');
        $param = array(
            'name' => $name,
            'address' => $address,
            'telephone' => $telephone
        );
        $status = Supplier::insertSupplier($param);
        return json_encode($status);
    }

    public function getAllData()
    {
        $data = Supplier::all();
        return json_encode(array('data' => $data));
    }

    public function deleteData(Request $request) {
        $id = $request->input('id');
        $status = Supplier::deleteSupplier($id);
        return json_encode($status);
    }


}
