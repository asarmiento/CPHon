@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Tipos de Asientos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Tipos de Asientos</a></li>
				<li class="active-page"><a>Editar Tipo de Asiento</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="abbreviationTypeSeat">Abreviacion del Tipo de Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="abbreviationTypeSeat" class="form-control" type="text" maxlength="5" value="{{ convertTitle($typeSeat->abbreviation) }}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameTypeSeat">Nombre del Tipo de Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="nameTypeSeat" class="form-control" type="text" value="{{ convertTitle($typeSeat->name) }}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="quantityTypeSeat">Cantidad del Tipo de Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="quantityTypeSeat" class="form-control" type="number" value="{{ $typeSeat->quantity }}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="yearTypeSeat">Año del Tipo de Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				      	<input id="yearTypeSeat" class="form-control" type="number" value="{{ $typeSeat->year }}">
					</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-tipos-de-asientos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="updateTypeSeat" data-url="tipos-de-asientos" class="btn btn-success">Actualizar Tipo de Asiento</a>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection