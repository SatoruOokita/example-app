<?php

namespace App\Services;

use App\Models\Tweet;
use Carbon\Carbon;

// 画像を含めたつぶやきの保存処理のために追加（p236）
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class TweetService
{

    // public function getTweets()
    // {
    //     return Tweet::with('images')->orderBy('created_at', 'DESC')->get();
    // }

    /**
     * 文字列検索機能を追加
     */
    public function getTweets($search = null, $match = null)
    {
        $query = Tweet::with('images')->orderBy('created_at', 'DESC');

        if (!is_null($search)) {
            switch ($match) {
                case 'partial':
                    $query->where('content', 'LIKE', '%' . $search . '%');
                    break;
                case 'prefix':
                    $query->where('content', 'LIKE', $search . '%');
                    break;
                case 'suffix':
                    $query->where('content', 'LIKE', '%' . $search);
                    break;
                default:
                    $query->where('content', 'LIKE', '%' . $search . '%');
            }
        }



        return $query->get();
    }


    /**
     * 自分のtweetかどうかをチェックするメソッド
     */
    public function checkOwnTweet(int $userId, int $tweetId): bool
    {
        $tweet = Tweet::where('id', $tweetId)->first();
        if (!$tweet) {
            return false;
        }

        return $tweet->user_id === $userId;
    }

    /**
     * 前日のつぶやきの数をカウントする
     */
    // public function countYesterdayTweets(): int
    // {
    //     return Tweet::whereDate(
    //         'created_at',
    //         '>=',
    //         Carbon::yesterday()->toDateTimeString()
    //     )
    //         ->whereDate(
    //             'created_at',
    //             '<',
    //             Carbon::today()->toDateTimeString()
    //         )
    //         ->count();
    // }

    /**
     * 画像を含めたつぶやきの保存処理のために追加（p236）
     */
    public function saveTweet(int $userId, string $content, array $images)
    {
        DB::transaction(function () use ($userId, $content, $images) {
            $tweet = new Tweet;
            $tweet->user_id = $userId;
            $tweet->content = $content;
            $tweet->save();
            foreach ($images as $image) {
                Storage::putFile('public/images', $image);
                $imageModel = new Image();
                $imageModel->name = $image->hashName();
                $imageModel->save();
                $tweet->images()->attach($imageModel->id);
            }
        });
    }

    /**
     * つぶやき削除時に、画像も一緒に削除されるようにする。
     */
    public function deleteTweet(int $tweetId)
    {
        DB::transaction(function () use ($tweetId) {
            $tweet = Tweet::where('id', $tweetId)->firstOrFail();
            $tweet->images()->each(function ($image) use ($tweet) {
                $filePath = 'public/images/' . $image->name;
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
                $tweet->images()->detach($image->id);
                $image->delete();
            });

            $tweet->delete();
        });
    }
}