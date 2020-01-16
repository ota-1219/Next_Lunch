<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManageRequest;
use App\Libs\deleteRequest;
use App\Libs\restaurantTableDAO;
use App\Libs\searchRestaurantDAO;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;

class DeleteRequestController extends Controller
{
    public function index($id)
    {
        // \Debugbar::info($id);
        $data = searchRestaurantDAO::getOneRestaurant($id);
        // \Debugbar::addMessage($data, 'とってきたデータ');
        return view('delete_request', compact('data'));
    }

    public function check(ManageRequest $req)
    {
        $data = $req->all();
        $data['reason_text'] = deleteRequest::getReasonText($req->input('reason'));
        return view('delete_request_check', compact('data'));
    }

    public function send(Request $req)
    {
        deleteRequest::putDeleteRequest($req);
        return redirect('/');
    }

    public function manage(Request $req)
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

        $data = self::paginate($req, $data, 5);

        // \Debugbar::info($reasonResult);
        // \Debugbar::info($data);
        return view('/manage_list', compact('data'));
    }

    public function accept($id)
    {
        deleteRequest::deleteRequestAccept($id);
        $restaurant_id = $id;
        restaurantTableDAO::removeGenre($restaurant_id);
        return redirect('/manage_list');
    }

    public function reject($id)
    {
        deleteRequest::deleteRequestReject($id);
        return redirect('/manage_list');
    }

    private static function paginate(object $req, array $data, int $perPage)
    {
        $displayData = array_chunk($data, $perPage);
        \Debugbar::addMessage($displayData, 'displayData');
        $currentPageNo = $req->input('page', 1);

        if (count($displayData) == 0) {
            // 検索結果が0件のときはページネーションでエラー出るので
            return $displayData;
        }

        $data = new LengthAwarePaginator(
            $displayData[$currentPageNo - 1],
            count($data),
            $perPage,
            $currentPageNo,
            array('path' => $req->url())
        );

        return $data;
    }
}
