<?php

namespace App\Http\Controllers;

use App\Libs\deleteRequest;
use App\Libs\restaurantTableDAO;
use App\Libs\searchRestaurantDAO;
use Session;

class ManageController extends Controller
{
    public function index()
    {
        if (!Session::has('id')) {
            return redirect('/');
        }
        $reqdata = deleteRequest::getDeleteRequest();
        \Debugbar::info($reqdata);

        $data = [];
        foreach ($reqdata as $key => $val) {
            $id = $val->restaurant_id;
            $reason = $val->reason;
            $note = $val->note;
            $reasonResult = deleteRequest::getReasonText($reason);
            $resData = searchRestaurantDAO::getOneRestaurant($id);

            $data[$key] = [
                'id' => $id,
                'reason' => $reasonResult,
                'resData' => $resData,
                'note' => $note,
            ];
        }
        // \Debugbar::info($reasonResult);
        // \Debugbar::info($data);
        return view('/manage_list', compact('data', 'reasonResult', 'note', 'resData'));
    }

    public function accept($id)
    {
        deleteRequest::deleteRequestAccept($id);
        $restaurant_id = $id;
        restaurantTableDAO::removeGenre($restaurant_id);
        return redirect('/');
    }

    public function reject($id)
    {
        deleteRequest::deleteRequestReject($id);
        return redirect('/');
    }
}
