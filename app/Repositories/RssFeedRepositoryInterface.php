<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface RssFeedRepositoryInterface
{
    public function getFeedsForUserId(int $userId): Collection;
}
