<?php

namespace App\Http\Controllers\Tweet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// テキストp067の内容
use App\Models\Tweet;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // return 'Single Action!';
        // return view('tweet.index', ['name' => 'Laravel(Tweet/IndexControllerのviewヘルパー関数に記述)']);

        /**
         * テキストp067の内容
         * Eloquentモデルを利用してデータを取得
         */
        // $tweets = Tweet::all();
        // ddヘルパー関数は、その場で処理を中断して変数の内容などを出力する。
        // dd($tweets);
        // return view('tweet.index')
        // ->with('name', 'Laravel')
        // ->with('version', '9');

        /**
         * テキストp068の内容
         * bladeテンプレートに$tweetsを渡す。
         */
        $tweets = Tweet::all();
        return view('tweet.index')
        ->with('tweets', $tweets);
    }
}
