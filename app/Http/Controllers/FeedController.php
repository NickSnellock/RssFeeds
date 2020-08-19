<?php
namespace App\Http\Controllers;

use App\Exceptions\InvalidRssFeed;
use App\Services\RssFeedService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    /**
     * @var RssFeedService
     */
    private $rssFeedService;

    /**
     * FeedController constructor.
     * @param RssFeedService $rssFeedService
     */
    public function __construct(RssFeedService $rssFeedService)
    {
        $this->rssFeedService = $rssFeedService;
    }

    public function addFeed()
    {
        return view('addfeed');
    }

    public function addNewFeed(Request $request)
    {
        $this->validate(
            $request,
            [
                'rss_url' => 'required|unique:rss_feed,rss_url,NULL,id,user_id,' . Auth::id(),
            ]
        );

        try {
            $this->rssFeedService->addFeed(Auth::id(), $request->input('rss_url'));
        } catch (InvalidRssFeed $invalidRssFeed) {
            return redirect()->back()->withErrors(['rss_url' => 'Invalid Feed URL']);
        }
        return redirect('/home');
    }
}
