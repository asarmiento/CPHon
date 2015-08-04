@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Menú</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Menú</a></li>
				<li class="active-page"><a>Registrar Menú</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameMenu">Nombre del Menú</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="nameMenu" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="urlMenu">Url del Menú</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-bars"></i></span>
				      	<input id="urlMenu" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="iconMenu">Ícono del Menú</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-info"></i></span>
				      	<input id="iconMenu" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-12 text-center">
				<div class="form-mep">
					<label>Escoger las opciones del Menú</label>
					@foreach($tasks as $task)
						<div class="row">
							<input class="task_menu" type="checkbox" name="task-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="{{$task->name}}" data-id="{{$task->id}}">
						</div>
					@endforeach
				</div>
			</div>
		</section>
		<section>
			<div class="row text-center">
				<a href="{{route('ver-menu')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
				<a href="#" id="saveMenu" data-url="menu" class="btn btn-success">Grabar Menú</a>
			</div>
		</section>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection