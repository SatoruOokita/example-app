<?php
// app/Services/TweetSearchService.php

namespace App\Services;

use App\Models\Tweet;

class TweetSearchService
{
    public function search(string $search, string $match = 'partial')
    {
        $query = Tweet::query();

        if (!empty($search)) {
            switch ($match) {
                case 'partial':
                    $query->where('content', 'LIKE', "%{$search}%");
                    break;
                case 'prefix':
                    $query->where('content', 'LIKE', "{$search}%");
                    break;
                case 'suffix':
                    $query->where('content', 'LIKE', "%{$search}");
                    break;
            }
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }
}