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
