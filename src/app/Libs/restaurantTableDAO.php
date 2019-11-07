<?php
namespace App\Libs;
use Illuminate\Support\Facades\DB;

class restaurantTableDAO
{
    public static function setGenre(array $genre, $restaurant_id)
    {
        foreach ($genre as $val) {
            DB::table('genre_of_restaurant')->insert(
                [
                    'restaurant_id' => $restaurant_id,
                    'genre_id' => $val,
                ]
            );
        }
        return null;
    }

    public static function removeGenre($restaurant_id)
    {
        DB::table('genre_of_restaurant')
        ->where('restaurant_id', '=', $restaurant_id)
        ->delete();
        return null;
    }

    public static function create($data)
    {
        $id = DB::table('restaurant')->insertGetid(
            [
                'name' => $data['name'],
                'lat' => $data['lat'],
                'lng' => $data['lng'],
                'distance' => $data['distance'],
                'time' => $data['time'],
                'use_count' => '1',
            ]
        );
        \Debugbar::info($data['genre_id']);

        self::setGenre($data['genre_id'], $id);
        return;
    }

    public static function update($data)
    {
        DB::table('restaurant')->where('id', '=', $data['id'])
        ->update([
            'name' => $data['name'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
            'distance' => $data['distance'],
            'time' => $data['time'],
        ]);

        self::removeGenre($data['id']);
        self::setGenre($data['genre_id'], $data['id']);

        return null;
    }

    public static function distanceCalc($end_lat, $end_lng)
    {
        $start_lat = 35.733688;
        $start_lng = 139.715643;

        $lat_dist = ($start_lat - $end_lat);
        if ($lat_dist < 0) {
            $lat_dist = $lat_dist * -1;
        }

        $lng_dist = ($start_lng - $end_lng);
        if ($lng_dist < 0) {
            $lng_dist = $lng_dist * -1;
        }

        //緯度位置における経度量を計算　地球は丸い
        $m_lng = 30.9221438 * cos($start_lat / 180 * pi());
        if ($m_lng < 0) {
            $m_lng = $m_lng * -1;
        }

        //移動量を計算
        return $distance = (int) (sqrt(pow(abs($lat_dist / 0.00027778 * 30.9221438), 2) + pow(abs($lng_dist / 0.00027778 * $m_lng), 2)));
    }

    public static function countUpUseCount(string $id)
    {
        return DB::table('restaurant')->where('id', $id)->increment('use_count');
    }
}