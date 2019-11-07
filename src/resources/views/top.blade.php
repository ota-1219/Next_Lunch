@extends('layout/base')
@section('title')
@section('contents')
    <div class="row">
        <div class="col-12">
            <h2 class="text-center">ようこそ</h2>
            <div class="mx-auto mb-2" style="width:250px;">
                <span class="h3"><span class="badge badge-warning">ジャンルを選択して検索</span></span>
            </div>


            <form action="/search" method="get" class="form-group">
                {{ csrf_field() }}
                @include('layout/genre')

                <div class="mt-3">
                    <p>検索条件を選択
                    <select class="form-control" name="searchConditions">
                        <option value="OR">OR検索</option>
                        <option value="AND">AND検索</option>
                        <option value="NOT">NOT検索</option>
                    </select>
                    </p>
                    <button type="submit" class="btn btn-warning form-control mt-3" value="search" name="searchType">検索</button>
                    <button type="submit" class="btn btn-info form-control mt-2" value="diceroll" name="searchType"><i class="fas fa-dice"></i> さいころで決める！</button>
                </div>
            </form>


            <div class="mt-3">
                <a class="btn alert-warning form-control" href="/create">お店を新しく登録する</a>
            </div>
        </div>

    <div class="row">
        <div class="col-12">
            <br>
            <h4 class="">飲食食店検索システム Next Lunchの使い方</h4>
            <ul class="p-4">
                <li><b>ジャンル検索</b><br>
                    検索したい料理のジャンルごとに検索ができます。<br>
                    また、OR検索やAND検索、NOT検索に対応しています。
                </li><br>
                <li><b>さいころで決める！</b><br>
                    登録されている飲食店の情報から、ランダムで3件表示します。<br>
                    食べたい料理のジャンルが決まってないときに押すと効果的です。
                </li><br>

            </ul>
        </div>
    </div>


    </div>
@endsection
@section('script')
<script src="{{ asset('js/genreCheckbox.js') }}"></script>
@endsection
