<?php

namespace App\Http\Controllers\Tweet;

use App\Models\Tweet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Tweet\UpdateRequest;
use App\Services\TweetService;
use App\Http\Requests\Tweet\CreateRequest;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;;

class TweetprocessController extends Controller
{
    // 元、 Tweet/IndexController.php
    // /tweetにアクセスがあった場合につぶやきの一覧を表示する
    public function indexcontroller(Request $request, TweetService $tweetService)
    {
        $search = $request->input('search');
        $match = $request->input('match');
        $tweets = $tweetService->getTweets($search, $match);

        return view('tweet.index')
            ->with('tweets', $tweets)
            ->with('search', $search)
            ->with('match', $match);
    }

    // 元、 Tweet/CreateController.php
    public function createcontroller(CreateRequest $request, TweetService $tweetService)
    {
        $tweetService->saveTweet(
            $request->userId(),
            $request->tweet(),
            $request->images()
        );
        return redirect()->route('tweet.index');
    }

    // 元、 Tweet/DeleteController.php
    public function deletecontroller(Request $request, TweetService $tweetService)
    {
        $tweetId = (int) $request->route('tweetId');
        // テキストp138の内容
        if (!$tweetService->checkOwnTweet($request->user()->id, $tweetId)) {
            throw new AccessDeniedHttpException();
        }
        $tweetService->deleteTweet($tweetId);
        return redirect()
            ->route('tweet.index')
            ->with('feedback.success', "つぶやきを削除しました。");
    }

    // 元、 Tweet/Update/IndexController.php
    public function updateindexcontroller(Request $request, TweetService $tweetService)
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

    // 元、 Tweet/Update/PutController.php
    public function updateputcontroller(UpdateRequest $request, TweetService $tweetService)
    {
        // テキストp138の内容
        if (!$tweetService->checkOwnTweet($request->user()->id, $request->id())) {
            throw new AccessDeniedHttpException();
        }

        $tweet = Tweet::where('id', $request->id())->firstOrFail();
        $tweet->content = $request->tweet();
        $tweet->save();
        return redirect()
            ->route('tweet.update.index', ['tweetId' => $tweet->id])
            ->with('feedback.success', "つぶやきを編集しました。");
    }
}