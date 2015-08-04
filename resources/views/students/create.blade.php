@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Estudiantes</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Estudiantes</a></li>
				<li class="active-page"><a>Registrar Estudiante</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="fnameStudent">Primer Nombre del Estudiante</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
				      	<input id="fnameStudent" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="snameStudent">Segundo Nombre del Estudiante</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
				      	<input id="snameStudent" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="flastStudent">Primer Apellido del Estudiante</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
				      	<input id="flastStudent" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="slastStudent">Segundo Apellido del Estudiante</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
				      	<input id="slastStudent" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="sexStudent">Sexo del Estudiante</label>
					<select id="sexStudent" class="form-control">
						<option value="hombre">Hombre</option>
						<option value="mujer">Mujer</option>
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="phoneStudent">Teléfono del Estudiante</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-mobile"></i></span>
				      	<input id="phoneStudent" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="addressStudent">Dirección del Estudiante</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
				      	<input id="addressStudent" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="degreeStudent">Grado del Estudiante</label>
					<select id="degreeStudent" class="form-control">
						@foreach($degrees as $degree)
							<option value="{{$degree->token}}">{{ convertTitle($degree->name) }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="discountTuitionStudent">Descuento por Matrícula</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-usd"></i></span>
				      	<input id="discountTuitionStudent" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="discountStudent">Descuento por Mensualidad</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-usd"></i></span>
				      	<input id="discountStudent" class="form-control" type="number">
					</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-estudiantes')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Ver Estudiantes</a>
			<a href="{{route('estudiantes-matriculados')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Ver Estudiantes Matriculados</a>
			<a href="#" id="saveStudent" data-url="estudiantes" class="btn btn-success">Grabar Estudiante</a>
		</div>
	</div>
@stop

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection