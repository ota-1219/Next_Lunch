<?php

namespace App\Http\Controllers;

use App\Libs\genreTableDAO;
use App\Libs\restaurantTableDAO;
use App\Libs\searchRestaurantDAO;
use App\Libs\sessionDAO;
use App\Http\Requests\RestaurantDataPost;
use Illuminate\Http\Request;
use Session;

class CreateController extends Controller
{
    /**
     * 飲食店新規登録画面
     *
     * @return array genre
     * @return int operation
     */
    public function create()
    {
        //新規登録
        $genre = genreTableDAO::allGenre();
        // \Debugbar::info($genre);
        $operation = 'create';
        return view('create', compact('genre', 'operation'));
    }

    /**
     * 飲食店登録確認画面
     * @param Illuminate\Http\Request $request
     * @return string operation
     * @return array create_check
     * @return array genre_select
     * @return int distResult
     * @return int walkSpeed
     * @return int endlat
     * @return int end_lng
     */
    public function create_check(RestaurantDataPost $request)
    {
        //新規登録確認画面
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
        $operation = 'create';
        return view('create_check', compact('operation', 'create_check', 'genre_select', 'distResult', 'walkSpeed', 'end_lat', 'end_lng'));
    }

    /**
     * 飲食店登録確認画面
     * @param Illuminate\Http\Request $req
     */
    public function create_done(Request $req)
    {
        //新規登録
        $data = $req->all();
        restaurantTableDAO::create($data);
        return redirect('/');
    }

}
