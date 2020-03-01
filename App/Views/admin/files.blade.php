@extends('layouts.base')

@section('title', 'Панель - файлы')
@section('content')
	<div class=container-fluid>
		<div class="row">
			<div class="col-sm-12 col-md-3 col-lg-3">
				@empty($files)
				<div class="alert theme alert-danger">
					Пусто
				</div>
				@else
				<div class="card theme">
					<div class="card-header theme">
						Файлы <span class="badge badge-success float-right">{{ count($files) }}</span>
					</div>
					<ul class="list-group list-group-flush">
						@foreach($files as $time => $file)
						<li class="list-group-item">
							@if ($file['type'] == 'dir')
							<a href="?path={{ $file['path'] }}" class="text-muted">
								<img src="{{ $file['icon'] }}" style="width: 18px; height: 18px;"> 
								{{ $file['name'] }}
								<span class="badge badge-warning float-right">{{ $file['time']->diffForHumans() }} </span>
							</a>
							@else
							<div class="text-muted">
								<img src="{{ $file['icon'] }}" style="width: 18px; height: 18px;"> 
								{{ $file['name'] }}
								<span class="badge badge-warning float-right">{{ $file['time']->diffForHumans() }} </span>
							</div>
							@endif
						</li>
						@endforeach
					</ul>
				</div>
				@endif
			</div>
		</div>
	</div>
@endsection