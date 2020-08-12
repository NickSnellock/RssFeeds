<?php
namespace App\Entities;

use Carbon\Carbon;

class FeedItem
{
    private $title;

    private $description;

    private $link;

    public function __construct(string $title, string $description, string $link)
    {
        $this->title = $title;
        $this->description = $description;
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }
}
