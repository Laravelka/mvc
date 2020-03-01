<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" lang=ru>
	<head>
		<meta charset=utf-8>
		<meta property="og:title" content="
			@hasSection('title')
				{{ config('app.name') }} - @yield('title')
			@else
				{{ config('app.name') }} - Мини MVC ядро
			@endif
		" />
		<meta property="og:image" content="{{ isset($ogImage) ? $ogImage : '/img/logo.png' }}" />
		<meta property="og:description" content="{{ isset($ogDescription) ? $ogDescription : 'Мини MVC ядро' }}" />
		<meta property="og:url" content="{{ isset($ogUrl) ? $ogUrl : request(true)->getUri() }}" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			@hasSection('title')
				{{ config('app.name') }} - @yield('title')
			@else
				{{ config('app.name') }} - Мини MVC ядро
			@endif
		</title>
		
		{{-- CSS --}}
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="/css/app.css?v=0.0.5">
		
		{{-- Javascript --}}
		<script src="/js/app.js?v=0.0.5"></script>
		<!--[if lt IE 9]><script src=http://html5shiv.googlecode.com/svn/trunk/html5.js></script><![endif]-->
		
		<script>
			$(document).ready(function() {
				$('.nav-toggle').on('click', function() {
					$('#menu').toggleClass('active');
				});
			}); 
		</script>
	</head>
	<body>
		<header>
			<nav class="navbar navbar-expand-lg navbar-dark header">
				<a class="navbar-brand" href="/">{{ config('app.name') }}</a>
				<div class="nav-right-menu pb-2 pr-2">
				    <div class="btn-group">
                        <button type="button" class="btn btn-link dropdown-toggle text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Menu
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">Action</button>
                            <button class="dropdown-item" type="button">Another action</button>
                            <button class="dropdown-item" type="button">Something else here</button>
                        </div>
                    </div>
				</div>
			</nav>
		</header>
		<div id="alerts" class="alerts-block" style="/*width: 240px*/"></div>
		<main class=mt-3 id=mainContent>
			@yield('content')
		</main>
		<footer>
			<div class="container mt-3">
				<div class=text-center>
					<span>Mini Core v0.5 © 2019</span></br>
				</div>
			</div>
		</footer>
	</body>
</html>