@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Institución</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Institución</a></li>
				<li class="active-page"><a>Registrar Institución</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameSchool">Nombre de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-university"></i></span>
				      	<input id="nameSchool" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="charterSchool">Cédula de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="charterSchool" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="routeSchool">Url de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="routeSchool" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="phoneOneSchool">Teléfono 1 de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone"></i></span>
				      	<input id="phoneOneSchool" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="phoneTwoSchool">Teléfono 2 de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone"></i></span>
				      	<input id="phoneTwoSchool" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="faxSchool">Fax de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone"></i></span>
				      	<input id="faxSchool" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="addressSchool">Dirección de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
				      	<input id="addressSchool" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="townSchool">Ciudad de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
				      	<input id="townSchool" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusSchool">Estado de la Institución</label>
					<div class="row">
			      		<input id="statusSchool" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
			      	</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-institucion')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="saveSchool" data-url="institucion" data-school="colegio/valle-de-angeles" class="btn btn-success">Grabar Institución</a>
		</div>
	</div>
@stop

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection