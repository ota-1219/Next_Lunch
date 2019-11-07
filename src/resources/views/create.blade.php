@extends('layout.base')
@section('title')
    @if($operation === 'create')
        飲食店登録
    @else
        飲食店編集
    @endif
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
            <form
            @if($operation === 'create')
                action="/create_check"
            @else
                action="/edit_check"
            @endif
            >
                {{ csrf_field() }}
                <table id="detail" class="table" style="height: 90%">
                <tr>
                    <th>
                        <small class="text-danger">*必須</small>
                        飲食店名
                    </th>
                    <td>
                        @if ($operation === 'edit')
                            <input type="hidden" name="id" value="{{ $data['id'] }}">
                        @endif
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        <input class="form-control" type="text" name="name" placeholder="登録したい飲食店の店名"
                        @if (isset($data['name']) && is_null(old('name')))
                            value="{{ $data['name'] }}"
                        @else
                            value="{{ old('name') }}"
                        @endif
                        >
                        <input type="text" id="end_lat" name="end_lat" style="display:none"
                        @if (isset($data['lat']) && is_null(old('end_lat')))
                            value="{{ $data['lat'] }}"
                        @else
                            value="{{ old('end_lat',35.733688) }}"
                        @endif
                        >
                        <input type="text" id="end_lng" name="end_lng" style="display:none"
                        @if (isset($data['lng']) && is_null(old('end_lng')))
                            value="{{ $data['lng'] }}"
                        @else
                            value="{{ old('end_lng', 139.715643) }}"
                        @endif
                        >
                    </td>
                </tr>
                <tr>
                    <th>
                        <small class="text-danger">*必須</small>
                        ジャンル
                    </th>
                    <td>
                        <span class="text-danger">{{ $errors->first('genre') }}</span>
                        @include('layout.genre')
                    </td>
                </tr>
            </table>

        </div>
        <div class="col-xs-12 col-md-6">
            <table id="detail2" class="table2 ml-3" >
                <th>地図</th>
                <tr>
                    <td>飲食店の場所にマーカーを移動してください</td>
                </tr>
            </table>
            <div id="map" style="width:40vw;height:25vw;min-width:300px;min-height:300px" class="mx-auto border mb-4">
            </div>
        </div>
        <div class="col-12 text-center border-top">
            <button type="submit" class="btn btn-lg btn-warning px-5 mt-3 text-light"><i class="fas fa-exclamation-circle"></i> <b>入力した内容を確認する</b></button><br>
            <button type="button" class="btn btn-lg btn-outline-warning px-5 mt-3"
            @if ($operation === 'create')
                onclick="location.href='/'"
            @else
                onclick="location.href='/detail/{{ $data['id'] }}'"
            @endif
            ><b>戻る</b></button>
        </div>
        </form>
    </div>
</section>
@endsection

@section('script')
<script src="http://maps.google.com/maps/api/js?key=AIzaSyD9R9DM8P145KKfmvQR-SEtGiShNRpa_9w&language=ja"></script>
<script src="{{ asset('js/map_create.js') }}"></script>
<script src="{{ asset('js/genreCheckbox.js') }}"></script>
@endsection
