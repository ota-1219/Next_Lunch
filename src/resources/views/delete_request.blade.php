@extends('layout.base')
@section('title','削除依頼')
@section('contents')
@if ((isset($data)) && (count($data) > 0))
<form action="/delete_request_check" method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-12 mb-2">
            <h2 class="d-inline">削除依頼</h2>
        </div>
        <div class="col-12 mx-auto">
                <table id="delete" class="table" style="height: 90%">
                <tr>
                    <th>飲食店名</th>
                    <td>
                        <input type="hidden" name="id" value="{{ $data['id'] }}">
                        <input type="hidden" name="name" value="{{ $data['name'] }}">
                        {{ $data['name'] }}
                    </td>
                </tr>
                <tr>
                    <th>ジャンル</th>
                    <td>
                        @foreach($data['genre'] as $genre)
                        <span class="h5"><span class="badge alert-secondary">{{ $genre['name'] }}</span></span>
                        <input type="hidden" name="genre[]" value="{{ $genre['name'] }}">
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>
                        <small class="text-danger">*必須</small>
                        削除依頼の理由
                    </th>
                    <td>
                        <span class="help-block text-danger">{{$errors->first('reason')}}<br></span>
                        <label><input type="radio" name="reason" value="0">既に登録されている飲食店と重複している</label><br>
                        <label><input type="radio" name="reason" value="1">不適切な内容が登録されている</label><br>
                        <label><input type="radio" name="reason" value="2">その他の理由</label><br><br>
                    </td>
                </tr>
                <tr>
                    <th>
                        <small class="text-danger">*必須</small>
                        詳細
                    </th>
                    <td>
                        <span class="help-block text-danger">{{$errors->first('note')}}<br></span>
                        <textarea name="note" cols="35" rows="5"></textarea>
                    </td>
                </tr>

            </table>

        </div>

        <div class="col-12 text-center border-top">
            <button class="btn btn-lg btn-warning px-5 mt-3 text-light" type="submit"><i class="fas fa-check-circle"></i> <b>確認</b></button><br>
            <button type="button" class="btn btn-lg btn-outline-warning px-5 mt-3" onclick="history.back()">戻る</button>
        </div>
    </div>
</form>
@endif
@endsection
@section('script')
@endsection
