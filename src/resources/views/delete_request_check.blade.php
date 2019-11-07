@extends('layout.base')
@section('title','削除依頼 - 確認')
@section('contents')
@if ((isset($data)) && (count($data) > 0))
<form action="/delete_request_send" method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-12 mb-2">
            <h2 class="d-inline">削除依頼</h2>
        </div>

        <div class="col-12 mx-auto">
            <form action="">
                <table id="delete" class="table" style="height: 90%">
                <tr>
                    <th>飲食店名</th>
                    <td>
                        <input type="hidden" name="id" value="{{ $data['id'] }}">
                        {{ $data['name'] }}
                    </td>
                </tr>
                <tr>
                    <th>ジャンル</th>
                    <td>
                        @foreach($data['genre'] as $genre)
                        <span class="h5"><span class="badge alert-secondary">{{ $genre }}</span></span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>削除依頼の理由</th>
                    <td>
                        {{ $data['reason_text'] }}
                        <input type="hidden" name="reason" value="{{ $data['reason'] }}">
                    </td>
                </tr>
                <tr>
                    <th>詳細</th>
                    <td>
                        {{ $data['note'] }}
                        <input type="hidden" name="note" value="{{ $data['note'] }}">
                    </td>
                </tr>
            </table>
            </form>
        </div>

        <div class="col-12 text-center border-top">
            <h5><i class="fas fa-exclamation-circle"></i>この内容で送信しますか？</h5>
            <button class="btn btn-lg btn-warning px-5 mt-3 text-light" type="submit"><i class="fas fa-check-circle"></i> <b>申請する</b></button><br>
            <button type="button" class="btn btn-lg btn-outline-warning px-5 mt-3" onclick="history.back()">戻る</button>
        </div>
    </div>
@endif
@endsection
@section('script')
@endsection
