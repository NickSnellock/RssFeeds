<?php
namespace App\Http\Controllers;

use App\Services\RssFeedService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController
{
    /**
     * @var RssFeedService
     */
    private $rssFeedService;

    /**
     * @var HomeController
     */
    private $homeController;

    /**
     * FeedController constructor.
     * @param RssFeedService $rssFeedService
     */
    public function __construct(RssFeedService $rssFeedService, HomeController $homeController)
    {
        $this->rssFeedService = $rssFeedService;
        $this->homeController = $homeController;
    }

    public function addFeed()
    {
        return view('addfeed');
    }

    public function addNewFeed(Request $request)
    {
        $this->rssFeedService->addFeed(Auth::id(), $request->input('rss_url'));

        return $this->homeController->index();
    }
}
