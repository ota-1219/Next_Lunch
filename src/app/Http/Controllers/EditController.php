<?php

namespace App\Http\Controllers;

use App\Libs\genreTableDAO;
use App\Libs\restaurantTableDAO;
use App\Libs\searchRestaurantDAO;
use App\Libs\sessionDAO;
use App\Http\Requests\RestaurantDataPost;
use Illuminate\Http\Request;
use Session;

class EditController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = searchRestaurantDAO::getOneRestaurant($id);
        $genre = genreTableDAO::allGenre();
        $operation = 'edit';
        \Debugbar::addMessage($data, 'restaurantData');
        return view('create', compact('data', 'genre', 'operation'));
    }

    public function edit_check(RestaurantDataPost $request)
    {
        //登録画面で選択されたジャンルを表示するためのDB接続
        $create_check = $request->all();
        // \Debugbar::info($request->all());
        $genre = $create_check['genre'];
        $genre_select = genreTableDAO::select($genre);
        // \Debugbar::info($genre_select);

        //緯度経度を計算させるやつ
        $end_lat = $create_check['end_lat'];
        $end_lng = $create_check['end_lng'];
        // \Debugbar::info($create_check['genre']);
        $distResult = restaurantTableDAO::distanceCalc($end_lat, $end_lng);

        $speedResult = $distResult / 60;
        $walkSpeed = ceil($speedResult);

        \Debugbar::info($end_lat, $end_lng);
        $operation = 'edit';
        return view('create_check', compact('operation', 'create_check', 'genre_select', 'distResult', 'walkSpeed', 'end_lat', 'end_lng'));
    }

    public function edit_done(Request $req)
    {
        $data = $req->all();
        \Debugbar::addMessage($data, '飛んできたデータ');
        restaurantTableDAO::update($data);
        return redirect('/detail/'.$data['id']);
    }
}
