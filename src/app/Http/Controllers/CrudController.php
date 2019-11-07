<?php

namespace App\Http\Controllers;

use App\Libs\genreTableDAO;
use App\Libs\restaurantTableDAO;
use App\Libs\searchRestaurantDAO;
use App\Libs\sessionDAO;
use App\Http\Requests\RestaurantDataPost;
use Illuminate\Http\Request;
use Session;

class CrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //新規登録
        $genre = genreTableDAO::allGenre();
        // \Debugbar::info($genre);
        $operation = 'create';
        return view('create', compact('genre', 'operation'));
    }

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

    public function create_done(Request $req)
    {
        //新規登録
        $data = $req->all();
        restaurantTableDAO::create($data);
        return redirect('/');
    }

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

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
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_request($id)
    {
        //削除依頼
        $data = searchRestaurantDAO::getOneRestaurant($id);

        return view('/delete_request', compact('data'));
    }

    public function delete_request_check(RestaurantDataPost $req)
    {
        //削除依頼確認

        return view('/delete_request', compact('data'));
    }
}
