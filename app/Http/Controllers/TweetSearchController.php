<?php
// app/Http/Controllers/TweetSearchController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TweetSearchService;

class TweetSearchController extends Controller
{
    protected $tweetSearchService;

    public function __construct(TweetSearchService $tweetSearchService)
    {
        $this->tweetSearchService = $tweetSearchService;
    }

    public function __invoke(Request $request)
    {
        $search = $request->input('search', ''); // デフォルト値を空文字に設定します。
        $match = $request->input('match', 'partial');
        $tweets = $this->tweetSearchService->search($search, $match);

        return view('tweet.index', compact('tweets', 'search', 'match'));
    }
}