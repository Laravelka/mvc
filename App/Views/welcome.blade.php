@extends('layouts.base')

@section('title', 'Добро пожаловать')
@section('content')
	<div class=container-fluid>
		<div class="row">
			<div class="col-sm-12 col-md-3 col-lg-3">
				<article class="card theme">
					<div class="card-header theme"><a href="/news/" class="text-muted">Новости</a></div>
					<div class=card-body>
						<h2 class=card-title>{{ $news['title'] }}</h2>
						<p>{{ $news['text'] }}</p>
					</div>
					<div class="card-footer theme">
						<a class="btn btn-sm btn-success btn-block theme" href="/news/id{{ $news['id'] }}">Читать дальше</a>
					</div>
				</article>
			</div>
			<div class="col-sm-12 col-md-6 col-lg-6">
				<article class="card theme">
					<div class="card-header theme">
						<a href="/forum/" class="text-muted">Форум <span class="badge badge-success">1</span></a>
					</div>
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<a href="#topic">Theme Title</a>
						</li>
					</ul>
				</article>
			</div>
			<div class="col-sm-12 col-md-3 col-lg-3">
				<article class="card theme">
					<div class="card-header theme">
						<a href="/auth" class="text-muted">Вход</a>
					</div>
					<div class="card-body">
						....
					</div>
				</article>
			</div>
		</div>
	</div>
@endsection
