@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			@foreach($tweets as $tweet)
				<div class="col-sm-8 mb-4">
					<div class="card">
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
			@endforeach
		</div>
	</div>
@endsection
