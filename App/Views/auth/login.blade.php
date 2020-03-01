@extends('layouts.base')

@section('title', 'Авторизация')
@section('content')
	<div class=container>
		<script>
			$(document).ready(function() {
				$.setParams({
					form: '#authForm', // id формы
					button: '#okAuthButton' // id кнопки, на которую будут кликать
				});
				$.apiForm('/api/login');
			});
		</script>
		<div class="row justify-content-center">
			<div class="col-sm-8 col-md-6 col-lg-5">
				<ul class="nav nav-pills theme mb-3 justify-content-center">
					<li class="nav-item">
						<a class="nav-link active" href="/login">Авторизация</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/register">Регистрация</a>
					</li>
				</ul>
				<div class="card theme">
					<div class="card-body">
						<form id="authForm" method="POST" data-prefix="auth">
							{!! csrf()->get('input') !!}
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" class="form-control" id="auth-email" name="email">
								<span class="invalid-feedback" id="auth-error-email" role="alert"></span>
							</div>
							<div class="form-group">
								<label for="password">Пароль</label>
								<input type="password" class="form-control" id="auth-password" name="password">
								<span class="invalid-feedback" id="auth-error-password" role="alert"></span>
							</div>
							<div class="form-check">
								<input type="checkbox" class="form-check-input" id="auth-remember" name="remember">
								<label class="form-check-label mt-2" for="remember">Запомнить меня</label>
								<span class="d-block invalid-feedback" id="auth-error-remember" role="alert"></span>
							</div>
						</form>
					</div>
					<div class="card-footer theme text-center">
						<button type="submit" class="btn btn-success theme btn-block mb-4" id="okAuthButton">Войти</button>
						<a href="/forgotPassword" class="text-muted">Забыли пароль?</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
