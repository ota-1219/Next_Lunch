<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\genreTableDAO;
use App\Libs\searchRestaurantDAO;


class SearchController extends Controller
{
    public function index()
    {
        $genre = genreTableDAO::allgenre();
        \Debugbar::addMessage($genre, 'data');
        return view('top', compact('genre'));
    }

    public function search(Request $req)
    {
        // 並び替えのときに使うので検索条件はhiddenしておく
        $searchType = $req->input('searchType');    //search|diceroll
        $searchConditions = $req->input('searchConditions');  //OR|AND|NOT
        $genre = $req->input('genre');
        $sort = $req->input('sort');

        $data = searchRestaurantDAO::search($req, 5, $sort);

        \Debugbar::addMessage($req->all(), '前ページからのリクエスト');
        \Debugbar::addMessage($data, 'Viewにわたすデータ');
        \Debugbar::addMessage($genre, '選択したジャンル');
        return view('list', compact('data', 'searchType','searchConditions', 'genre', 'sort'));
    }
}