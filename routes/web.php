<?php

use App\Http\Controllers\ProfileController;
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
 * テキストp136の内容
 * ユーザー情報が必要な画面については、ログインしていないとアクセスできないようにルーティングを書き換えている。
 * Route::middleware()を使うことで、複数のルートにミドルウェアを指定することができる。
 */
Route::middleware('auth')->group(function () {

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

    /**
     * 『プロフェッショナルWebプログラミング for Laravel9』p094
     *  ・つぶやきを削除する機能のエンドポイント追加
     */
    Route::delete('/tweet/delete/{tweetId}', \App\Http\Controllers\Tweet\DeleteController::class)
        ->name('tweet.delete');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';