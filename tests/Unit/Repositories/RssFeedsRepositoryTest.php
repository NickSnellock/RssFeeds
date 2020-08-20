<?php

namespace Tests\Unit\Repositories;

use App\Entities\RssFeed;
use App\Repositories\RssFeedRepositoryInterface;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RssFeedsRepositoryTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    public function testGetFeedsForUserId()
    {
        $users = factory(User::class, 2)->create();
        $rssFeed = factory(RssFeed::class)->create(['user_id' => $users[0]->id]);
        $rssFeed2 = factory(RssFeed::class)->create(['user_id' => $users[1]->id]);

        /** @var RssFeedRepositoryInterface $rssFeedRepository */
        $rssFeedRepository = $this->app->get(RssFeedRepositoryInterface::class);

        $rssFeedRetruned = $rssFeedRepository->getFeedsForUserId($rssFeed->user_id);

        $this->assertEquals(1, $rssFeedRetruned->count());

        $this->assertEquals($rssFeed->rss_url, $rssFeedRetruned->first()->rss_url);
    }

    public function testStoreFeed()
    {
        $user = factory(User::class)->create();

        /** @var RssFeedRepositoryInterface $rssFeedRepository */
        $rssFeedRepository = $this->app->get(RssFeedRepositoryInterface::class);

        $this->assertDatabaseMissing(
            'rss_feed',
            [
                'user_id' => $user->id,
            ]
        );

        $rssFeedRepository->storeFeed($user->id, 'test url');

        $this->assertDatabaseHas(
            'rss_feed',
            [
                'user_id' => $user->id,
                'rss_url' => 'test url',
            ]
        );
    }
}
