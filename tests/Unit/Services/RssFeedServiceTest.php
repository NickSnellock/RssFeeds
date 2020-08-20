<?php

namespace Tests\Unit\Services;

use App\Entities\RssFeed;
use App\Entities\RssFeedDetail;
use App\Exceptions\InvalidRssFeed;
use App\Repositories\RssFeedRepositoryInterface;
use App\Services\RssFeedService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class RssFeedServiceTest extends TestCase
{
    public function testAddFeedValidUrl()
    {
        $this->expectNotToPerformAssertions();

        $rssFeedRepository = Mockery::spy(RssFeedRepositoryInterface::class);
        $rssFeedRepository->shouldReceive('storeFeed');

        app()->instance(RssFeedRepositoryInterface::class, $rssFeedRepository);

        /** @var RssFeedService $rssFeedService */
        $rssFeedService = app()->get(RssFeedService::class);

        $rssFeedService->addFeed(1, 'http://feeds.bbci.co.uk/news/rss.xml');

        $rssFeedRepository->shouldHaveReceived('storeFeed');
    }

    public function testAddFeedInvalidUrl()
    {
        $rssFeedRepository = Mockery::mock(RssFeedRepositoryInterface::class);
        $rssFeedRepository->shouldReceive('storeFeed');

        app()->instance(RssFeedRepositoryInterface::class, $rssFeedRepository);

        /** @var RssFeedService $rssFeedService */
        $rssFeedService = app()->get(RssFeedService::class);

        $this->expectException(InvalidRssFeed::class);

        $rssFeedService->addFeed(1, 'x');
    }

    public function testAddFeedUrlNotFound()
    {
        $rssFeedRepository = Mockery::mock(RssFeedRepositoryInterface::class);
        $rssFeedRepository->shouldReceive('storeFeed');

        app()->instance(RssFeedRepositoryInterface::class, $rssFeedRepository);

        /** @var RssFeedService $rssFeedService */
        $rssFeedService = app()->get(RssFeedService::class);

        $this->expectException(InvalidRssFeed::class);

        $rssFeedService->addFeed(1, 'http://not.found');
    }

    public function testGetFeedsForUserFeedsFound()
    {
        $rssFeeds = new Collection([new RssFeed(['user_id' => 1, 'rss_url' => 'http://feeds.bbci.co.uk/news/rss.xml'])]);

        $rssFeedRepository = Mockery::mock(RssFeedRepositoryInterface::class);
        $rssFeedRepository->shouldReceive('getFeedsForUserId')->andReturn($rssFeeds);

        app()->instance(RssFeedRepositoryInterface::class, $rssFeedRepository);

        /** @var RssFeedService $rssFeedService */
        $rssFeedService = app()->get(RssFeedService::class);

        $rssData = $rssFeedService->getFeedsForUser(1);

        $this->assertInstanceOf(Collection::class, $rssFeeds);

        $this->assertEquals(1, $rssData->count());
        $this->assertInstanceOf(RssFeedDetail::class, $rssData->first());
    }
}
