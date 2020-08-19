@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="./add_new_feed" method="post">
                    @csrf
                <div class="card">
                    <div class="card-header">{{ __('Add feed') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                {!! implode('', $errors->all('<div>:message</div>')) !!}
                            </div>
                        @endif
                        <input type="url" size="50" name="rss_url" class="@error('url') is-invalid @enderror" />
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Add Feed</button>
                <a href="/home" class="btn btn-warning">Cancel</a>
                </form>
            </div>

        </div>
    </div>
@endsection
