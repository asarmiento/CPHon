@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/lib/daterangepicker-bs3-test.css') }}">	
@endsection

@section('page')
	<aside class="page"> 
		<h2>Reportes</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Reportes</a></li>
				<li class="active-page"><a>Balance de Comprobación</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="text-center">
				<label class="text-center">Rango de Fechas</label>
				<div class="form-group">
					<div class="input-group col-sm-4 col-sm-offset-4">
						<input id="startDate" type="hidden" value="{{ $periodInitial }}">
						<input id="endDate" type="hidden" value="{{ $periodFinal }}">
						<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span><input id="txtDate" type="text" class="form-control">
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript" src="{{ asset('js/lib/moment-test.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/lib/daterangepicker-test.js') }}"></script>
	<script type="text/javascript" src="{{ asset('bower_components/jquery-file-download/src/Scripts/jquery.FileDownload.js') }}"></script>
@endsection