@extends('layouts.base')

@section('title', $news['title'])
@section('content')
	<div class=container>
		<div class="row justify-content-center">
			<div class="col-sm-8 col-md-6 col-lg-5">
				<article class="card theme">
					<div class="card-header theme">{{ $news['title'] }}</div>
					<div class=card-body>
						<p>{{ $news['text'] }}</p>
					</div>
					<div class="card-footer theme">
						Добавил: <a href="/user/id{{ $news['user_id'] }}">id{{ $news['user_id'] }}</a>
					</div>
				</article>
			</div>
		</div>
	</div>
@endsection
