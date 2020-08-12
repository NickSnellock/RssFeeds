<?php
namespace App\Repositories;

use App\Entities\RssFeed;
use Illuminate\Database\Eloquent\Collection;

class RssFeedRepository implements RssFeedRepositoryInterface
{
    public function getFeedsForUserId(int $userId): Collection
    {
        $feeds = RssFeed::where('user_id', $userId)->get();
        return $feeds;
    }

    public function storeFeed(int $userId, string $url)
    {
        $rssfeed = new RssFeed();
        $rssfeed->user_id = $userId;
        $rssfeed->rss_url = $url;

        $rssfeed->save();
    }
}
