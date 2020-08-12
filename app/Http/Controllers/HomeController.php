<?php

namespace App\Http\Controllers;

use App\Services\RssFeedService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * @var RssFeedService
     */
    private $rssFeedService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RssFeedService $rssFeedService)
    {
        $this->middleware('auth');
        $this->rssFeedService = $rssFeedService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rssfeeds = $this->rssFeedService->getFeedsForUser(Auth::id());
        return view('home', ['rssfeeds' => $rssfeeds]);
    }
}
