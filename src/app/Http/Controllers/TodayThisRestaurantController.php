<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\restaurantTableDAO;

class TodayThisRestaurantController extends Controller
{
    // Ajax
    public function countUpUseCount(Request $req)
    {
        return restaurantTableDAO::countUpUseCount($req->input('id'));
    }
}