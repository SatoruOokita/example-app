<?php

namespace App\Http\Controllers\Tweet;

use App\Http\Controllers\Controller;
// テキストp067の内容
use App\Models\Tweet;
// テキストp105の内容(TweetServiceのインポート)
use App\Services\TweetService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, TweetService $tweetService)
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
        // $tweets = Tweet::all();
        // return view('tweet.index')
        // ->with('tweets', $tweets);

        /**
         * テキストp082の内容
         * Eloquentモデルがクエリビルダとしても機能できることを利用した取得方法。
         * SQL句のようにselect, where, orderBy, Limitなどを使って条件付きでデータを取得することができる。
         */
        // $tweets = Tweet::orderBy('created_at', 'DESC')->get();
        // return view('tweet.index')
        //     ->with('tweets', $tweets);

        /**
         * テキストp105の内容
         * ・冒頭のuse命令で、TweetServiceクラスを利用できるようにししている。
         * ・TweetServiceのインスタンスを作成し、つぶやきの一覧を取得
         */
        $tweets = $tweetService->getTweets();
        return view('tweet.index')
            ->with('tweets', $tweets);
    }
}