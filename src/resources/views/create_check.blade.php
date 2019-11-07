@extends('layout.base')
@section('title')
    @if($operation === 'create')
        飲食店登録
    @else
        飲食店編集
    @endif
     - 確認
@endsection
@section('contents')
<section>
    <div class="row">
        <div class="col-12 mb-2">
            <h2 class="d-inline">
                @if($operation === 'create')
                    飲食店登録
                @else
                    飲食店編集
                @endif
            </h2>
        </div>
        <div class="col-xs-12 col-md-6">
            <form method="POST"
            @if($operation === 'create')
                action="/create_done"
            @else
                action="/edit_done"
            @endif
            >
                {{ csrf_field() }}
                <table id="detail" class="table" style="height: 90%">
                <tr>
                    <th>飲食店名</th>
                    <td>{{ $create_check['name'] }}</td>
                    @if ($operation === 'edit')
                        <input type="hidden" name="id" value="{{ $create_check['id'] }}">
                    @endif
                    <input type="hidden" name="name" value="{{ $create_check['name'] }}">
                </tr>
                <tr>
                    <th>ジャンル</th>
                    <td>
                        @foreach($genre_select as $data)
                        <span class="badge alert-secondary">{{ $data->name }}</span>
                        <input type="hidden" name="genre_id[]" value="{{ $data->id }}">
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>距離</th>
                    <td>
                        {{-- 時速4km = 約分速66m --}}
                        {{ $distResult }}m（徒歩{{ $walkSpeed }}分）
                        <input type="hidden" name="lat" value="{{ $end_lat }}">
                        <input type="hidden" name="lng" value="{{ $end_lng }}">
                        <input type="hidden" name="distance" value="{{ $distResult }}">
                        <input type="hidden" name="time" value="{{ $walkSpeed }}">
                    </td>
                </tr>
            </table>

        </div>
        <div class="col-xs-12 col-md-6">
            <table id="detail2" class="table2 ml-3">
                <th>地図</th>
            </table>
            @if ($distResult <= 9)
                <p class="text-center"><span class="text-danger">その位置は本社ですが、このままでよろしいですか？</span></p>
            @endif

            <div id="map" style="width:40vw;height:25vw;min-width:300px;min-height:300px" class="mx-auto border mb-4">
            </div>
        </div>

        <div class="col-12 text-center border-top">
            <h5><i class="fas fa-exclamation-circle"></i>
                @if($operation === 'create')
                    この内容で登録しますか？
                @else
                    この内容で変更しますか？
                @endif
            </h5>
            <button type="submit" class="btn btn-lg btn-warning px-5 mt-3 text-light"><i class="fas fa-check-circle"></i> <b>
                @if($operation === 'create')
                    登録する
                @else
                    変更する
                @endif
            </b></button><br>
        </form>

            <button type="button" class="btn btn-lg btn-outline-warning px-5 mt-3" onclick="history.back()"><b>戻る</b></button>
        </div>
    </div>

    <?php
        $param = array($end_lat,$end_lng);
        function json_safe_encode($data){
            return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        }
    ?>
</section>


@endsection
@section('script')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyD9R9DM8P145KKfmvQR-SEtGiShNRpa_9w&language=ja"></script>
<script id="script" src="{{ asset('js/map_check.js') }}" data-param='<?php echo json_safe_encode($param);?>'></script>
@endsection
