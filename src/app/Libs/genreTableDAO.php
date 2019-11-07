<?php
namespace App\Libs;
use Illuminate\Support\Facades\DB;

class genreTableDAO
{
    public static function allGenre()
    {
        $group = DB::table('genre_group')->orderby('id', 'asc')->get();
        $genreData = array();
        foreach ($group as $key => $value) {
            $genreData[$value->name] = DB::table('genre')->where('group_id', $key+1)->get();
        }
        return json_decode(json_encode($genreData), true);
    }

    public static function select($genre)
    {
        // foreach ($genre as $data) {
        //     DB::table('genre')->where('id', $data)->select('name')->first();
        // }return $result;
        $genreSelect = DB::table('genre')->where('id', '');
        foreach ($genre as $vals) {
            $genreSelect->orWhere('id', $vals);
        }return $genreSelect->get();
    }
}