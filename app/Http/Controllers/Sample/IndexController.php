<?php

namespace App\Http\Controllers\Sample;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * 『プロフェッショナルWebプログラミング for Laravel9』p042
     *  showメソッドを作成し、Helloという文字列を返す
     * @return string
     * 
    */
    public function show()
    {
        return 'Hello';
    }
    /**
     * 『プロフェッショナルWebプログラミング for Laravel9』p043
     *  URLからの値を取得する
     * @return string
     * 
    */
    public function showId($id)
    {
        return "Hello {$id}";
    }
}
