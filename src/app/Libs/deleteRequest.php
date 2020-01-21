<?php
namespace App\Libs;

use Illuminate\Support\Facades\DB;

class deleteRequest
{
    public static function getReasonText($reason)
    {
        switch ($reason) {
            case '0':
                return '既に登録されている飲食店と重複している';
            case '1':
                return '不適切な内容が登録されている';
            case '2':
                return 'その他の理由';
            default:
                return '';
        }
    }

    public static function putDeleteRequest($req)
    {
        return DB::table('delete_request')->insert(
            [
                'restaurant_id' => $req['id'],
                'reason' => $req['reason'],
                'note' => $req['note'],
            ]
        );
    }

    public static function getDeleteRequest()
    {
        return DB::table('delete_request')->get();
    }

    public static function deleteRequestAccept($id)
    {
        DB::table('delete_request')->where('restaurant_id', $id)->delete();
        DB::table('restaurant')->where('id', $id)->delete();
        return null;
    }

    public static function deleteRequestReject($id)
    {
        DB::table('delete_request')->where('restaurant_id', $id)->delete();
        return null;
    }

    public static function commit_test()
    {

    }
}
