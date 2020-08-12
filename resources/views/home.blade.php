@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Rss Feeds') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @forelse ($rssfeeds as $rssfeed)
                        <div class="card">
                            <div class="card-header">
                                <div class="row" data-toggle="collapse" data-target="#items{{ $loop->index }}">
                                <div class="col-md-4">
                                    <img src="{{ $rssfeed->getFeedImage() }}" />
                                </div>
                                <div class="col-md-4">
                                    {{ $rssfeed->getFeedName() }}
                                </div>
                                </div>
                            </div>
                            <div class="card-body collapse" id="items{{ $loop->index }}">
                        @foreach($rssfeed->getFeedItems() as $feedItem)
                            <a href="{{ $feedItem->getLink() }}">
                            <div class="row">
                                <div class="col-md12">
                                    <strong>
                                    {{ $feedItem->getTitle() }}
                                    </strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    {{ $feedItem->getDescription() }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr />
                                </div>
                            </div>
                            </a>
                        @endforeach
                            </div>
                    @empty
                            <p>No feeds set up</p>
                    @endforelse
                        </div>
                </div>
            </div>
            <a class="btn btn-primary" id="add_feed" href="./add-feed">Add a new feed URL</a>
        </div>
    </div>
</div>
@endsection
