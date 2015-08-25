<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
	<title>Account Hon</title>
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/lib/nprogress.css') }}">
	@yield('styles')
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="Menu">
		<div class="Menu-logo">
			<figure>
				<a href="{{ url('/') }}"><img class="center-block" src="{{ asset('images/logo.jpg') }}"></a>
			</figure>
		</div>
		@include('layouts.partials.menu')
	</nav>
	<section class="content-wrapper">
		@include('layouts.partials.header')
		@yield('page')
		@yield('content')
	</section>
	<!-- Scripts -->
	<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
	<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('bower_components/blockUI/jquery.blockUI.js') }}"></script>
	<script src="{{ asset('bower_components/bootbox/bootbox.js') }}"></script>
	<script src="{{ asset('bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('js/lib/nprogress.js') }}"></script>
	@yield('scripts')
	<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>