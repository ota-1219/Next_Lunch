<?php

namespace App\Http\Controllers;

use App\Libs\genreTableDAO;
use App\Libs\restaurantTableDAO;
use App\Libs\searchRestaurantDAO;
use App\Libs\sessionDAO;
use App\Http\Requests\RestaurantDataPost;
use Illuminate\Http\Request;
use Session;

class DetailController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        //詳細画面
        // $data = restaurantTableDAO::show($id);
        // \Debugbar::info($data);
        $data = searchRestaurantDAO::getOneRestaurant($id);
        // $genre_data = array_pluck($data, 'genre.name');
        // \Debugbar::info($data);
        // \Debugbar::info($genre_data);
        return view('/detail', compact('data'));
    }
}
