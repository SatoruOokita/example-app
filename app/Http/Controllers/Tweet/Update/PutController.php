<?php

namespace App\Http\Controllers\Tweet\Update;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// テキストp091の内容
use App\Http\Requests\Tweet\UpdateRequest;
use App\Models\Tweet;   // まず、対象のEloquentモデルを取得する
// テキストp139の内容
use App\Services\TweetService;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;;

class PutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * テキストp091の内容
     * memo
     * 取得したEloquentモデルのcontentを更新してsaveメソッドから保存を実行し、元の編集ページにリダイレクトしている。
     * リダイレクトする際に、メソッドチェーンでwithを利用して、フラッシュセッションデータを追加している。フラッシュセッションデータは、その名の通り一度きりしか表示されないデータとなるため、完了の通知などに利用できる。
     * フラッシュセッションデータを表示できるようにするには、resources/views/tweet/update.blade.phpでも記述を付け加える必要がある。
     */
    public function __invoke(UpdateRequest $request, TweetService $tweetService)
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