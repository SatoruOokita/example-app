<?php

namespace App\Http\Controllers\Tweet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// テキストp074の内容
use App\Http\Requests\Tweet\CreateRequest;
// テキストp080の内容
use App\Models\Tweet;
// コントローラからサービスクラスを利用して画像付きのつぶやきを保存(p237)
use App\Services\TweetService;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * __invokeメソッドの引数に、CreateRequestを指定して、p073で独自に拡張したFormRequestクラスをコントローラで利用する。
     */
    // public function __invoke(CreateRequest $request)
    // {
    // テキストp080の内容
    //     $tweet = new Tweet;
    //     $tweet->user_id = $request->userId();   // ここでUserIdを保存している
    //     $tweet->content = $request->tweet();
    //     $tweet->save();
    //     return redirect()->route('tweet.index');
    // }

    // コントローラからサービスクラスを利用して画像付きのつぶやきを保存(p237)
    public function __invoke(CreateRequest $request, TweetService $tweetService)
    {
        $tweetService->saveTweet(
            $request->userId(),
            $request->tweet(),
            $request->images()
        );
        return redirect()->route('tweet.index');
    }
}