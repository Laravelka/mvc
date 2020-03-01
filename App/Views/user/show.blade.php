@extends('layouts.base')

@section('title', 'Профиль '.$user['login'])
@section('content')
	<div class=container>
		<div class="row justify-content-center">
			<div class="col-sm-8 col-md-6 col-lg-5">
				<article class="card theme">
					<div class="profile-cover p-3" style="/*background-image: url();*/">
						<div class="d-flex justify-content-between text-light w-100 mb-4 pb-3">
							<b>{{ '@'.$user['login'] }}</b>
							<span style="margin-top: 1px">{{ $user['updated_at']->diffForHumans() }}</span>
						</div>
						<div class="d-flex justify-content-center align-items-center w-100">
							<div class="profile-avatar rounded-circle" style="/*background-image: url();*/"></div>
						</div>
					</div>
					<div class="card-body d-flex justify-content-between">
						<a href="#sendMessage" class="btn btn-success theme">Написать</a>
						<a href="#subscribe" class="btn btn-success theme">Подписаться</a>
					</div>
					<div class="card-footer theme">
						<div class="mb-1">Имя: {{ $user['first_name'] }}</div>
						<div class="mb-1">Фамилия: {{ $user['last_name'] }}</div>
						<div class="mb-1">E-mail: {{ $user['email'] }}</div>
						<div class="mb-1">
							Дата реги: {{ $user['created_at']->diffForHumans() }}
						</div>
						<div class="mb-1">Баланс: {{ $user['money'] }} ₽</div>
					</div>
				</article>
			</div>
		</div>
	</div>
@endsection
