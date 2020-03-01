@extends('layouts.base')

@section('title', 'Панель')
@section('content')
	<div class=container-fluid>
		<div class="row">
			<div class="col-sm-12 col-md-3 col-lg-3">
				<div class="card theme">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<a href="/admin/files">Файлы</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
@endsection