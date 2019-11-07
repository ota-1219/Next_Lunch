@extends('layout.base')
@section('contents')
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
<section>
    <div class="row">
        <div class="col-12">
            <h2 class="d-inline">飲食店詳細</h2>
            <div class="text-right mb-3">
                <a href="/edit/{{ $data['id'] }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i> 編集する</a>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <table id="detail" class="table" style="height: 90%">
                <tr>
                    <th>飲食店名</th>
                    <td>{{ $data['name'] }}</td>
                </tr>
                <tr>
                    <th>ジャンル</th>
                    <td>
                        @foreach($data['genre'] as $genre)
                        <span class="badge alert-secondary">{{ $genre['name'] }}</span>
                        <input type="hidden" name="genre_id[]" value="{{ $genre['genre_id'] }}">
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>距離</th>
                    <td>{{ $data['distance'] }}m（約{{ $data['time'] }}分）</td>
                </tr>
                <tr>
                    <th>利用回数</th>
                    <td>{{ $data['use_count'] }}回</td>
                </tr>
            </table>
        </div>
        <div class="col-xs-12 col-md-6">
            <div id="map" style="width:40vw;height:25vw;min-width:300px;min-height:300px"class="mx-auto border">
            </div>

            <p class="text-right mb-0 mt-2">
                <a href="/delete_request/{{ $data['id'] }}" class=" text-muted">
                    <small>
                        削除依頼
                    </small>
                </a>
            </p>

        </div>
        <div class="col-12 text-center border-top">
            <button class="btn btn-lg btn-warning px-5 mt-3 text-light todaythisButton" data-toggle="modal" data-target="#modal">
                <input type="hidden" class="restaurant_id" value="{{ $data['id'] }}">
                <input type="hidden" class="restaurant_name" value="{{ $data['name'] }}">
                <input type="hidden" class="lat" value="{{ $data['lat'] }}">
                <input type="hidden" class="lng" value="{{ $data['lng'] }}">
                <i class="fas fa-user-check"></i><b>今日はここ</b>
            </button><br>
            <button type="button" class="btn btn-lg btn-outline-warning px-5 mt-3" onclick="history.back()">戻る</button>
        </div>
    </div>
</section>

<!-- モーダルの設定 -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="modalMap" style="width:100%;height:35vw;min-width:300px;min-height:300px;" class="border">
                {{-- ここにマップが表示される --}}
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $param = array($data['lat'],$data['lng']);
    function json_safe_encode($val){
        return json_encode($val, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    }
?>

@endsection

@section('script')
<script src="{{ asset('/js/todayThisRestaurant.js') }}"></script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyD9R9DM8P145KKfmvQR-SEtGiShNRpa_9w&language=ja"></script>
<script id="script" src="{{ asset('js/map_detail.js') }}" data-param='<?php echo json_safe_encode($param);?>'></script>

@endsection
