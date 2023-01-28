<?php

namespace App\Http\Controllers\Tweet\Update;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// テキストp086の内容
use App\Models\Tweet;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
// テキストp138
use App\Services\TweetService;

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
        /** 
         * テキストp86の内容
         * Routeで{tweetId}と指定したため、Requestから「$request->route('tweetId')」を取得できる。
         */
        $tweetId = (int) $request->route('tweetId');
        // テキストp138の内容
        if (!$tweetService->checkOwnTweet($request->user()->id, $tweetId)) {
            throw new AccessDeniedHttpException();
        }

        $tweet = Tweet::where('id', $tweetId)->firstOrFail();
        return view('tweet.update')->with('tweet', $tweet);
        // if(is_null($tweet)){
        //     throw new NotFoundHttpException('存在しないつぶやきです。');
        // }
        // dd($tweetId);
    }
}