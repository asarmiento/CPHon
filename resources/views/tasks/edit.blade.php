@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Tareas</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Tareas</a></li>
				<li class="active-page"><a>Editar Tarea</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="idTask">Código de la Tarea</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-key"></i></span>
				      	<input id="idTask" class="form-control" type="text" value="{{$task->id}}" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameTask">Nombre de la Tarea</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tasks"></i></span>
				      	<input id="nameTask" class="form-control" type="text" value="{{mb_convert_case($task->name, MB_CASE_TITLE, 'utf-8')}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusTask">Estado de la Tarea</label>
					<div class="row">
						@if($task->deleted_at)
				      		<input id="statusTask" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado">
				      	@else
							<input id="statusTask" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
				      	@endif
			      	</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-tareas')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="updateTask" data-url="tareas" class="btn btn-success">Actualizar Tarea</a>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection