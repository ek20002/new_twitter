@extends('layouts.app')

@section('content')

	<div class="container">
		<div class="card">
			<div class="card-header">Create New Tweet</div>
			<div class="card-body">
				<form action="{{ route('tweets.store') }}" method="post">
					@csrf
					<div class="form-group">
						<label for=""></label>
						<input type="text" name="title" class="form-control" placeholder="tweet title">
					</div>
					<div class="form-group">
						<textarea name="body" class="form-control" placeholder="tweet body" rows="5"></textarea>
					</div>
					<button class="btn btn-secondary">Create Tweet</button>
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
@endsection