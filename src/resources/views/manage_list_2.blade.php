@extends('layout/manage')
@section('title','管理画面')
@section('contents')

<div class="row">
    <div class="col-12">
        <h2>管理画面</h2>
        @if (count($data) == 0)
            <p>削除依頼はありません。</p>
        @else
        <h5>ユーザーから届いた削除依頼の一覧が表示されています。</h5>

        <table id="list" class="table table-striped">
            <tr>
                <th style="width:30%">飲食店名</th>
                <th style="width:60%">削除依頼の理由</th>
                <th style="width:10%" colspan="2">操作</th>

            </tr>
        @foreach($data as $key=>$val)
            <tr>
                <td>
                    {{-- {{ $val['id'] }} --}}
                    <a href="/detail/{{ $val['resData']['id'] }}">{{ $val['resData']['name'] }}</a>
                </td>
                <td>
                    {{-- <b>既に登録されている飲食店と重複している</b><br>
                    備考：すでに同じ名前の飲食店が登録されている<br><br> --}}
                    <b>{{ $val['reason'] }}</b><br>
                    詳細：{{ $val['note'] }}<br>
                    <label><input id="check" name="check[{{ $val['resData']['id'] }}]" type="checkbox">内容を確認しました</label>
                </td>
                <td>{{-- <a id="acceptCheck" href="deleteAccept/{{ $val['resData']['id'] }}" class="btn btn-sm btn-success px-2 text-light"><i class="fas fa-user-check"></i> <b>受理</b></a> --}}
                    <a id="accept" name="acceptCheck[{{ $val['resData']['id'] }}]" class="btn btn-sm alert-secondary px-2 text-light disabled" tabindex="-1" aria-disabled="true"><i class="fas fa-user-check"></i> <b>受理</b></a>
                </td>
                <td>{{-- <a href="deleteReject/{{ $val['resData']['id'] }}" class="btn btn-sm btn-danger px-2 text-light"><i class="fas fa-user-check"></i> <b>棄却</b></a> --}}
                    <a id="reject" name="rejectCheck[{{ $val['resData']['id'] }}]" class="btn btn-sm alert-secondary px-2 text-light disabled" tabindex="-1" aria-disabled="true"><i class="fas fa-user-check"></i> <b>棄却</b></a>
                </td>
            </tr>
        @endforeach

        </table>
        @endif
    </div>
</div>


</div>

<?php
if(isset($val)){
    $param = $val['resData']['id'];
        function json_safe_encode($data){
            return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        }
}

?>
@endsection

@section('script')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
@if(isset($param))
<script id="script" src="{{ asset('js/manageCheckbox.js') }}" data-param="{{ $param }}"></script>
@endif
@endsection
