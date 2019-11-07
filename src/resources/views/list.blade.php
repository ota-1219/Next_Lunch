@extends('layout/base')
@section('title','検索結果')
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('contents')
<div class="row">
    <div class="col-12">
        <h2>検索結果</h2>
        @if ($searchType == 'diceroll')
            <div class="alert alert-warning text-center">
                <h3><i class="fas fa-dice"></i>さいころを振りました<i class="fas fa-dice"></i></h3>
                <a class="btn btn-outline-warning mt-2 form-control" onclick="location.reload()">振り直す</a>
            </div>
        @endif

        @if (count($data) == 0)
            <p>検索条件に一致する飲食店はありませんでした。</p>
        @else
        @if ($searchType == 'search')
        <form class="form-inline mb-2" action="/search" method="get" name="reSearch">
            {{ csrf_field() }}
            <input type="hidden" name="searchConditions" value="{{ $searchConditions }}">
            <input type="hidden" name="searchType" value="{{ $searchType }}">
            <input type="hidden" name="sort" value="{{ $sort }}">
            <input type="hidden" name="searchType" value="search">
            @if(isset($genre) && count($genre) > 0)
                @foreach ($genre as $val)
                    <input type="hidden" name="genre[]" value="{{ $val }}">
                @endforeach
            @endif
            <div class="form-group">
                <label class="mr-2">並び替えの条件</label>
                <select name="sort" class="form-control" onChange="submit()">
                    <option class="sortSelect" value="useMany">利用回数が多い順</option>
                    <option class="sortSelect" value="near">距離が近い順</option>
                    <option class="sortSelect" value="new">登録が新しい順</option>
                    <option class="sortSelect" value="useFew">利用回数が少ない順</option>
                    <option class="sortSelect" value="far">距離が遠い順</option>
                    <option class="sortSelect" value="old">登録が古い順</option>
                </select>
            </div>
        </form>
        @endif
        <table id="list" class="table table-striped">
            <tr>
                <th style="width:20%">飲食店名</th>
                <th style="width:40%">ジャンル</th>
                <th style="width:20%" colspan="2">距離</th>
                <th style="width:10%">利用回数</th>
                <th style="width:10%"></th>
            </tr>
            @foreach ($data as $val)
            <tr>
                <td>
                    @if ($searchType == 'diceroll')
                    <i class="fas fa-dice-{{ $val['diceicon'] }}"></i>
                    @endif
                    <a href="/detail/{{ $val['id'] }}">{{ $val['name'] }}</a>
                </td>
                <td>
                    @foreach ($val['genre'] as $genre)
                        <span class="h5"><span class="badge alert-secondary">{{ $genre['name'] }}</span></span>
                    @endforeach
                </td>
                <td class="pr-0">{{ $val['distance'] }}m</td>
                <td class="pl-0">（徒歩約{{ $val['time'] }}分）</td>
                <td>{{ $val['use_count'] }}回</td>

                <td>
                    <button class="btn btn-sm btn-warning px-2 text-light todaythisButton" data-toggle="modal" data-target="#modal">
                        <input type="hidden" class="restaurant_id" value="{{ $val['id'] }}">
                        <input type="hidden" class="restaurant_name" value="{{ $val['name'] }}">
                        <input type="hidden" class="lat" value="{{ $val['lat'] }}">
                        <input type="hidden" class="lng" value="{{ $val['lng'] }}">
                        <i class="fas fa-user-check"></i><b>今日はここ</b>
                    </button>
                </td>
            </tr>
            @endforeach
        </table>
        <span class="text-center">{{ $data->appends(request()->input())->links() }}</span>

        @endif
    </div>
</div>
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

@endsection
@section('script')
<script src="{{ asset('/js/todayThisRestaurant.js') }}"></script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyD9R9DM8P145KKfmvQR-SEtGiShNRpa_9w&language=ja"></script>
<script src="{{ asset('/js/select_check.js') }}"></script>
@endsection
