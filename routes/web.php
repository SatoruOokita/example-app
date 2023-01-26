<?php

use Illuminate\Support\Facades\Route;

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
// Route::get('', []);

Route::get('/', function () {
    return view('welcome');
});
/**
 * 『プロフェッショナルWebプログラミング for Laravel9』p042
 *  
 * /sampleにGETメソッドでリクエストされた場合に、
 * \App\Http\Controllers\Sample\IndexControllerコントローラのshowメソッドへルーティングされるという設定。
*/
Route::get('/sample', [\App\Http\Controllers\Sample\IndexController::class, 'show']);

/**
 * 『プロフェッショナルWebプログラミング for Laravel9』p043
 * URLの値を取得するshowIdメソッド
 * ルータで{id}と記述することでコントローラのメソッドの引数で$idを受け取れるようになる。
*/
Route::get('/sample/{id}', [\App\Http\Controllers\Sample\IndexController::class, 'showId']);

/**
 * 「/tweet」にリクエストがあった場合に、このコントローラへルーティングする
 *  ・シングルアクションコントローラの場合は、ルーティングに対応するメソッド名は不要で、classのみ指定する
 *  ・Routeには名前をつけることができ、別のコントローラーやBladeテンプレートからRouteを呼び出す際にパスではなく、その名前で指定できるようになる。
*/
Route::get('/tweet', \App\Http\Controllers\Tweet\IndexController::class)
->name('tweet.index');

/**
 * 『プロフェッショナルWebプログラミング for Laravel9』p074
 */
Route::post('/tweet/create', \App\Http\Controllers\Tweet\CreateController::class)
->name('tweet.create');

/**
 * 『プロフェッショナルWebプログラミング for Laravel9』p085
 *  ・編集ページをHTTPのGETで表示し、更新処理をPUTとしている。
 *  ・メソッドチェーン「->where('tweetId', '[0-9]+')」で、tweetIdが整数値のものを受け付ける。
 */
Route::get('/tweet/update/{tweetId}', \App\Http\Controllers\Tweet\Update\IndexController::class)
->name('tweet.update.index')->where('tweetId', '[0-9]+');
Route::put('/tweet/update/{tweetId}', \App\Http\Controllers\Tweet\Update\PutController::class)
->name('tweet.update.put')->where('tweetId', '[0-9]+');
