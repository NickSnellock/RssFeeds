<?php
namespace App\Entities;

use Illuminate\Support\Collection;

class RssFeedDetail
{
    private $feedName;

    private $feedUrl;

    private $feedImage;

    private $feedItems;

    public function __construct(string $feedName, string $feedUrl, string $feedImage, Collection $feedItems)
    {
        $this->feedName = $feedName;
        $this->feedUrl = $feedUrl;
        $this->feedImage = $feedImage;
        $this->feedItems = $feedItems;
    }

    /**
     * @return string
     */
    public function getFeedName(): string
    {
        return $this->feedName;
    }

    /**
     * @return string
     */
    public function getFeedUrl(): string
    {
        return $this->feedUrl;
    }

    /**
     * @return string
     */
    public function getFeedImage(): string
    {
        return $this->feedImage;
    }

    /**
     * @return Collection
     */
    public function getFeedItems(): Collection
    {
        return $this->feedItems;
    }
}
