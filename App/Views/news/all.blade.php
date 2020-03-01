@extends('layouts.base')

@section('title', 'Все новости')
@section('content')
	<div class=container>
		<div class="row justify-content-center">
			<div class="col-sm-8 col-md-6 col-lg-5">
			@empty($arrNews)
				<div class="alert alert-danger text-center">
					Новостей пока нет
				</div>
			@else
				@foreach($arrNews as $news)
				<article class="card theme">
					<div class="card-header theme">{{ $news['title'] }}</div>
					<div class=card-body>
						<p>{{ $news['text'] }}</p>
					</div>
					<div class="card-footer theme">
						Добавил: <a href="/user/id{{ $news['user_id'] }}" class="text-muted">{{ $news['login'] }}</a>
					</div>
				</article>
				@endforeach
			@endif
			</div>
		</div>
	</div>
@endsection
