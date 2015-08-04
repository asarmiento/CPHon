@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Usuarios</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Usuarios</a></li>
				<li class="active-page"><a>Registrar Usuario</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row form-user">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameUser">Nombres del Usuario</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
				      	<input id="nameUser" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="lastUser">Apellidos del Usuario</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
				      	<input id="lastUser" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="emailUser">Email del Usuario</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
				      	<input id="emailUser" class="form-control" type="email">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="passwordUser">Password del Usuario</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				      	<input id="passwordUser" class="form-control" type="password">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="typeUser">Tipo de Usuario</label>
					<select id="typeUser" class="form-control">
				      	@foreach($typeUsers as $typeUser)
							<option value="{{$typeUser->id}}">{{mb_convert_case($typeUser->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="schools">Instituciones</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-university"></i></span>
				      	<input id="schools" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusUser">Estado del Usuario</label>
					<div class="row">
			      		<input id="statusUser" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
			      	</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-usuarios')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="saveUser" data-url="usuarios" class="btn btn-success">Grabar Usuario</a>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
	<script src="{{ asset('bower_components/typeahead.js/dist/typeahead.bundle.min.js') }}"></script>
	<script src="{{ asset('bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
@endsection