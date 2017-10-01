<?php

namespace App\Http\Controllers;

use App\item_types;
use Illuminate\Http\Request;

use App\Http\Requests;

class ItemTypeController extends Controller
{
    public function getAllData() {
        $data = item_types::all();
        return json_encode(array('data' => $data));
    }

    public function insertNewData(Request $request) {
        $type_name = $request->input('type_name');
        $data = item_types::create([
           'name_type' => $type_name
        ]);
        if($data) {
            $status = true;
        } else {
            $status = false;
        }
        return json_encode(array('data' => $status));
    }

    public function deleteData(Request $request) {
        $itemId = $request->input('id');
        $data = item_types::deleteItemTypes($itemId);
        return json_encode(array('data' => $data));
    }

    public function getEditItem(Request $request) {
        $itemId = $request->input('id');
        $data = item_types::getOneData('id_type', $itemId);
        return json_encode($data[0]);
    }

    public function updateItem(Request $request) {
        $itemId = $request->input('idCheck');
        $type_name = $request->input('type_name');
        $paramUpdate = array('id' => $itemId, 'name_type' => $type_name);
        $data = item_types::updateData('id_type', $paramUpdate);
        return json_encode(array('data' => $data));
    }
}
