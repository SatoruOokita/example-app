<?php

namespace App\Http\Controllers\Tweet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tweet;   // Eloquentモデルを取得
// テキストp139の内容
use App\Services\TweetService;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, TweetService $tweetService)
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
}