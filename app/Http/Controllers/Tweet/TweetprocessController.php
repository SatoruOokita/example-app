<?php

namespace App\Http\Controllers\Tweet;

use App\Models\Tweet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Tweet\UpdateRequest;
use App\Services\TweetService;
use App\Http\Requests\Tweet\CreateRequest;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class TweetprocessController extends Controller
{
    private $tweetService_variable;

    public function __construct(TweetService $tweetService)
    {
        $this->tweetService_variable = $tweetService;
    }

    public function indexcontroller(Request $request)
    {
        $search = $request->input('search');
        $match = $request->input('match');
        $tweets = $this->tweetService_variable->getTweets($search, $match);

        return view('tweet.index')
            ->with('tweets', $tweets)
            ->with('search', $search)
            ->with('match', $match);
    }

    public function createcontroller(CreateRequest $request)
    {
        $this->tweetService_variable->saveTweet(
            $request->userId(),
            $request->tweet(),
            $request->images()
        );
        return redirect()->route('tweet.index');
    }

    public function deletecontroller(Request $request)
    {
        $tweetId = (int) $request->route('tweetId');
        if (!$this->tweetService_variable->checkOwnTweet($request->user()->id, $tweetId)) {
            throw new AccessDeniedHttpException();
        }
        $this->tweetService_variable->deleteTweet($tweetId);
        return redirect()
            ->route('tweet.index')
            ->with('feedback.success', "つぶやきを削除しました。");
    }

    public function updateindexcontroller(Request $request)
    {
        $tweetId = (int) $request->route('tweetId');
        if (!$this->tweetService_variable->checkOwnTweet($request->user()->id, $tweetId)) {
            throw new AccessDeniedHttpException();
        }

        $tweet = Tweet::where('id', $tweetId)->firstOrFail();
        return view('tweet.update')->with('tweet', $tweet);
    }

    public function updateputcontroller(UpdateRequest $request)
    {
        if (!$this->tweetService_variable->checkOwnTweet($request->user()->id, $request->id())) {
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