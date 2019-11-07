<?php
namespace App\Libs;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class searchRestaurantDAO
{
    /**
     * @param string $id restaurant ID
     * @return array $data a restaurant data
     */
    public static function getOneRestaurant(string $id)
    {
        $query = self::makeBaseTable();
        $query->where('restaurant.id', '=', $id);
        if (is_null($query->first())) {return null;}
        $data = self::objToArray($query->first());
        $data = self::addGenre($data);
        return $data;
    }

    /**
     * @param string $searchType search|diceroll
     * @param Request $req
     * @param int $perPage 一度に何件表示するか
     * @param string $sort 並び替え条件。
     *                     useMany 利用回数が多い順
     *                     near 距離が近い順
     *                     new 登録が新しい順
     *                     useFew 利用回数が少ない順
     *                     far 距離が遠い順
     *                     old 登録が古い順
     * @param string $id ID検索したい時に入れる
     * @return array self:paginate 取得した飲食店の連想配列。
     */
    public static function search(object $req, int $perPage, string $sort = null)
    {
        if (is_null($sort)) {$sort = 'useMany';}
        $genre = $req->input('genre');
        $searchType = $req->input('searchType');    //search|diceroll
        $searchConditions = $req->input('searchConditions');  //OR|AND|NOT
        \Debugbar::addMessage($sort, '並び替え条件(Model内)');
        \Debugbar::addMessage($searchType, 'searchType');

        $query = self::makeBaseTable();

        self::setSearchConditions($query, $searchConditions, $genre);

        if ($searchType == 'diceroll') {
            $query->inRandomOrder()->limit(3);
        } else {
            self::setSort($query, $sort);
        }

        $data = self::objToArray($query->get());
        $data = self::addGenre($data);
        if ($searchType == 'diceroll') { $data = self::addDiceicon($data); }

        return self::paginate($req, $data, $perPage);
    }

    private static function makeBaseTable()
    {
        $query = DB::table('restaurant')->distinct()
        ->addSelect([
            'restaurant.id',
            'restaurant.name',
            'lat',
            'lng',
            'distance',
            'time',
            'use_count',
        ])
        ->join('genre_of_restaurant', 'restaurant.id', '=', 'genre_of_restaurant.restaurant_id')
        ->join('genre', 'genre_of_restaurant.genre_id', '=', 'genre.id');

        return $query;
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

    private static function genreOfRestaurant(string $id)
    {
        $data = DB::table('genre_of_restaurant')
        ->addSelect(['genre_id', 'name'])
        ->join('genre', 'genre_of_restaurant.genre_id', '=', 'genre.id')
        ->where('restaurant_id', $id)->get();
        return self::objToArray($data);
    }

    private static function addGenre(array $data)
    {
        foreach ($data as $key => $val) {
            // \Debugbar::info($key);
            if ($key === 'id') {
                //一次元配列だったとき（id指定で飲食店データ取る時）
                // \Debugbar::info($data);
                $data['genre'] = self::genreOfRestaurant($val);
                return $data;
            }
            $data[$key]['genre'] = self::genreOfRestaurant($val['id']);
        }
        return $data;
    }

    private static function addDiceicon(array $data)
    {
        $num = ['one', 'two', 'three', 'four', 'five', 'six'];
        for ($i=0; $i < count($data) ; $i++) {
            $data[$i]['diceicon'] = $num[$i%6];
        }
        return $data;
    }

    private static function setSort(object $query, string $sort)
    {
        switch ($sort) {
        case 'useMany':
            return $query->orderBy('use_count', 'desc');
        case 'useFew':
            return $query->orderBy('use_count', 'asc');
        case 'near':
            return $query->orderBy('distance', 'asc');
        case 'far':
            return $query->orderBy('distance', 'desc');
        case 'new':
            return $query->orderBy('restaurant.id', 'desc');
        case 'old':
            return $query->orderBy('restaurant.id', 'asc');
        default:
            return null;
        }
    }

    private static function setSearchConditions(object $query, string $searchConditions, array $genre=null)
    {
        if (is_null($genre)) {
            return null;
        }
        switch ($searchConditions) {
        case 'OR':
            return $query->whereIn('genre.id', $genre);
        case 'AND':
            $subTable = DB::table('genre_of_restaurant')
            ->select(DB::raw('restaurant_id, count(*) as genre_count'))
            ->whereIn('genre_id', $genre)
            ->groupBy('restaurant_id');

            // \Debugbar::info($subTable->get());
            $subWhere = DB::table(DB::raw("({$subTable->toSql()}) as tmp"))
            ->select('restaurant_id')
            // toSql()使うせいで改めてバインドし直さないといけないのが気持ち悪い
            ->setBindings($genre)
            ->where('genre_count',  '>=',  count($genre));
            \Debugbar::info($subWhere->get());

            return $query->whereIn('restaurant.id', $subWhere);
        case 'NOT':
            $subQuery = DB::table('restaurant')->distinct()
            ->addSelect(['restaurant.id'])
            ->join('genre_of_restaurant', 'restaurant.id', '=', 'genre_of_restaurant.restaurant_id')
            ->whereIn('genre_id', $genre);
            return $query->whereNotIn('restaurant.id', $subQuery);
        default:
            return null;
        }
    }

    private static function objToArray(object $obj)
    {
        return json_decode(json_encode($obj), true);
    }
}