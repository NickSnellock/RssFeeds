<?php
namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \Tests\TestCase;

class FeedControllerTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function testDisplayAddForm()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/add-feed');

        $response->assertStatus(200);

        $response->assertSee('Add feed');
    }

    public function testAddFeed()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post(
            '/add_new_feed',
            [
                'user_id' => $user->id,
                'rss_url' => 'https://www.reddit.com/r/worldnews/.rss'
            ]
        );

        $response->assertStatus(302);

        $this->assertDatabaseHas(
            'rss_feed',
            [
                'user_id' => $user->id,
                'rss_url' => 'https://www.reddit.com/r/worldnews/.rss',
            ]
        );
    }
}
