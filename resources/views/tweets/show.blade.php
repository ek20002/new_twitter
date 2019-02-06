@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 mb-4">
                <div class="card border-primary">
                    <div class="card-header">
                        <h4>
                            <a href="{{ route('tweets.show' , $tweet->id) }}">{{ $tweet->title }}</a>
                            <small>create by {{ $tweet->user->name ?? 'no name' }}</small>
                        </h4>
                    </div>
                    <div class="card-body">
                        {{ $tweet->body }}
                    </div>
                </div>
            </div>

            @foreach($comments as $comment)
                <div class="col-sm-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <small>Comment by {{ $comment->user->name ?? 'no name' }}</small>
                        </div>
                        <div class="card-body">
                            {{ $comment->body }}
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-sm-8 mb-3">
                <div class="card">
                    <div class="card-header">send new comment</div>
                    <div class="card-body">
                        <form action="{{ route('tweet.comments.store' , $tweet->id) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <textarea name="body" class="form-control" placeholder="comment body" rows="5"></textarea>
                            </div>
                            <button class="btn btn-secondary">Create Comment</button>
                        </form>
                        @if($errors->any())
                            <ul class="alert alert-danger mt-5">
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
