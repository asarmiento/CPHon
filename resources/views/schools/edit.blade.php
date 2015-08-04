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
				<li class="active-page"><a>Editar Institución</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="idSchool">Id de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa fa-key"></i></span>
				      	<input id="idSchool" class="form-control" type="text" value="{{$school->id}}" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameSchool">Nombre de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-university"></i></span>
				      	<input id="nameSchool" class="form-control" type="text" value="{{ convertTitle($school->name) }}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="charterSchool">Cédula de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="charterSchool" class="form-control" type="text" value="{{ convertTitle($school->charter) }}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="routeSchool">Route de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="routeSchool" class="form-control" type="text" value="{{ convertTitle($school->route) }}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="phoneOneSchool">Teléfono 1 de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone"></i></span>
				      	<input id="phoneOneSchool" class="form-control" type="number" value="{{$school->phoneOne}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="phoneTwoSchool">Teléfono 2 de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone"></i></span>
				      	<input id="phoneTwoSchool" class="form-control" type="number" value="{{$school->phoneTwo}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="faxSchool">Fax de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone"></i></span>
				      	<input id="faxSchool" class="form-control" type="number" value="{{$school->fax}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="addressSchool">Dirección de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
				      	<input id="addressSchool" class="form-control" type="text" value="{{ convertTitle($school->address) }}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="townSchool">Ciudad de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
				      	<input id="townSchool" class="form-control" type="text" value="{{ convertTitle($school->town) }}"}}>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusSchool">Estado de la Institución</label>
					<div class="row">
						@if($school->deleted_at)
				      		<input id="statusSchool" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado">
				      	@else
							<input id="statusSchool" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
				      	@endif
			      	</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-institucion')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="updateSchool" data-url="institucion" class="btn btn-success">Actualizar Institución</a>
		</div>
	</div>
@stop

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection