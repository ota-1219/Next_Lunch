<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
//トップ画面
Route::get('/', 'SearchController@index');

//検索
Route::get('/search', 'SearchController@search');

//新規登録
Route::match(['get', 'post'], 'create', 'CreateController@create');
Route::match(['get', 'post'], 'create_done', 'CrudController@create_done');
Route::get('create_check', 'CreateController@create_check');

//詳細画面
Route::get('/detail/{id}', 'DetailController@store');

// 編集
Route::get('/edit/{id}', 'EditController@edit');
Route::get('/edit_check', 'EditController@edit_check');
Route::post('/edit_done', 'EditController@edit_done');

//削除依頼
Route::get('/delete_request/{id}', 'DeleteRequestController@index');
Route::post('/delete_request_check', 'DeleteRequestController@check');
Route::post('/delete_request_send', 'DeleteRequestController@send');
Route::get('/deleteAccept/{id}', 'DeleteRequestController@accept');
Route::get('/deleteReject/{id}', 'DeleteRequestController@reject');
//管理画面
Route::match(['get', 'post'], '/manage_list', 'DeleteRequestController@manage');

//ログイン
Route::match(['get', 'post'], 'login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');

// 今日はここボタン
Route::post('/countup', 'TodayThisRestaurantController@countUpUseCount');
