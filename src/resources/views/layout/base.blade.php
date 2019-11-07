<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('head')
<title>Next Lunch @yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
<header class="container-field bg-warning">
    <div class="row">
        <div class="col-6">
            <a href="/" style="text-decoration: none;"><h1 class="text-light m-0 pl-3">NextLunch</h1></a>
        </div>
        <div class="col-6 text-right">
            <p class="m-0 pt-4 pr-3">
                @if(Session::has('errorMessage'))
                    <span class="text-danger">{{ session('errorMessage') }}</span>
                @endif
                @if (Session::has('id'))
                    <a class="text-white" href="/manage_list" style="text-decoration: none;">管理画面へ</a>
                @else
                    <a class="text-white" href="/manage_list" data-toggle="modal" data-target="#exampleModalCenter" style="text-decoration: none;">管理画面へ</a>
                @endif
            </p>

            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">管理画面へログイン</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    <form method="POST" action="/login">
                        {{ csrf_field() }}
                        <input class="form-control" name="password" type="password" placeholder="パスワードを入力してください">
                    </div>
                    <div class="modal-footer">
                    <input class="btn btn-warning" type="submit" value="ログイン">
                    </form>
                    </div>
                </div>
                </div>
            </div>

        </div>
    </div>
</header>
<div class="container-field p-3">
@yield('contents')
</div>

<footer class="text-center border-top">Copyright©TokyoMethod</footer>

    <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    @yield('script')
</body>
</html>
