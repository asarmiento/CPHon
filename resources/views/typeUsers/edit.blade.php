@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Tipos de Usuarios</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Tipos de Usuarios</a></li>
				<li class="active-page"><a>Editar Tipo de Usuario</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="idTypeUser">Código del Tipo de Usuario</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-key"></i></span>
				      	<input id="idTypeUser" class="form-control" type="text" value="{{$typeUser->id}}" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameTypeUser">Nombre del Tipo de Usuario</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
				      	<input id="nameTypeUser" class="form-control" type="text" value="{{mb_convert_case($typeUser->name, MB_CASE_TITLE, 'utf-8')}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusTypeUser">Estado del Menú</label>
					<div class="row">
						@if($typeUser->deleted_at)
				      		<input id="statusTypeUser" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado">
				      	@else
							<input id="statusTypeUser" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
				      	@endif
			      	</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-tipos-de-usuarios')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="updateTypeUser" data-url="tipos-de-usuarios" class="btn btn-success">Actualizar Menú</a>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection