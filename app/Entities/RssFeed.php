<?php
namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RssFeed
 * @package App\Entities
 *
 * @property int $user_id
 * @property string $rss_url
 */
class RssFeed extends Model
{
    protected $table = 'rss_feed';

    protected $fillable = [
        'user_id',
        'rss_url',
    ];
}
