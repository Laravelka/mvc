@extends('layouts.base')

@section('title', 'Регистрация')
@section('content')
	<div class=container>
		<script>
			$(document).ready(function() {
				$.setParams({
					form: '#regForm', // id формы
					button: '#okRegButton' // id кнопки, на которую будут кликать
				});
				$.apiForm('/api/register');
			});
		</script>
		<div class="row justify-content-center">
			<div class="col-sm-8 col-md-6 col-lg-5">
				<ul class="nav nav-pills theme mb-3 justify-content-center">
					<li class="nav-item">
						<a class="nav-link" href="/login">Авторизация</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="/register">Регистрация</a>
					</li>
				</ul>
				<div class="card theme">
					<div class="card-body">
						<form id="regForm" method="POST" data-prefix="reg">
							{!! csrf()->get('input') !!}
							<div class="form-group">
								<label for="login">Логин</label>
								<input type="text" class="form-control" id="reg-login" name="login">
								<span class="invalid-feedback" id="reg-error-login" role="alert"></span>
							</div>
							<div class="form-group">
								<label for="first_name">Имя</label>
								<input type="text" class="form-control" id="reg-first_name" name="first_name">
								<span class="invalid-feedback" id="reg-error-first_name" role="alert"></span>
							</div>
							<div class="form-group">
								<label for="last_name">Фамилия</label>
								<input type="text" class="form-control" id="reg-last_name" name="last_name">
								<span class="invalid-feedback" id="reg-error-last_name" role="alert"></span>
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" class="form-control" id="reg-email" name="email">
								<span class="invalid-feedback" id="reg-error-email" role="alert"></span>
							</div>
							<div class="form-group">
								<label for="password">Пароль</label>
								<input type="password" class="form-control" id="reg-password" name="password">
								<span class="invalid-feedback" id="reg-error-password" role="alert"></span>
							</div>
						</form>
					</div>
					<div class="card-footer theme text-center">
						<button type="submit" class="btn btn-success theme btn-block mb-4" id="okRegButton">Войти</button>
						<a href="/forgotPassword" class="text-muted d-none">Забыли пароль?</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
