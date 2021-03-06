<?php
namespace App\Services;

use App\Entities\FeedItem;
use App\Entities\RssFeedDetail;
use App\Exceptions\InvalidRssFeed;
use App\Repositories\RssFeedRepositoryInterface;
use Illuminate\Support\Collection;

class RssFeedService
{
    /**
     * @var RssFeedRepositoryInterface
     */
    private $rssFeedRepository;

    /**
     * RssFeedService constructor.
     */
    public function __construct(RssFeedRepositoryInterface $rssFeedRepository)
    {
        $this->rssFeedRepository = $rssFeedRepository;
    }

    public function getFeedsForUser(int $userId): Collection
    {
        $urls = $this->rssFeedRepository->getFeedsForUserId($userId);

        $rssData = new \Illuminate\Support\Collection();

        foreach ($urls as $url) {
            try {
                $rssXml = simplexml_load_file($url->rss_url);
            } catch (\Exception $ex) {
                throw new InvalidRssFeed();
            }

            $title = (string)$rssXml->channel->title;
            $image = (string)$rssXml->channel->image->url;

            $rssItems = new \Illuminate\Support\Collection();

            foreach ($rssXml->channel->item as $item) {
                $rssItemTitle = html_entity_decode((string)$item->title, ENT_QUOTES);
                $rssItemDescription = strip_tags(html_entity_decode((string)$item->description, ENT_QUOTES));
                $rssItemLink = (string)$item->link;

                $rssItems->add(new FeedItem($rssItemTitle, $rssItemDescription, $rssItemLink));
            }

            $rssData->add(new RssFeedDetail($title, $url->rss_url, $image, $rssItems));
        }

        return $rssData;
    }

    /**
     * @param int $userId
     * @param string $url
     *
     * Simple validation - simlexml_load_file will throw an exception if url is invalid or does not return xml
     */
    public function addFeed(int $userId, string $url)
    {
        libxml_use_internal_errors(true);
        try {
            $rssXml = simplexml_load_file($url);
        } catch (\Exception $ex) {
            throw new InvalidRssFeed();
        }

        if ($rssXml === false) {
            libxml_clear_errors();
            throw new InvalidRssFeed();
        }

        $this->rssFeedRepository->storeFeed($userId, $url);
    }
}
