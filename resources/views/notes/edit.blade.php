@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Notas</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Notas</a></li>
				<li class="active-page"><a>Editar Nota</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="descriptionNote">Descripción de la Nota</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="descriptionNote" class="form-control" type="text" value="{{ convertTitle($note->description) }}" data-token="{{$note->token}}" >
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="dateNote">Fecha de la Nota</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				      	<input id="dateNote" class="form-control" type="date" value="{{ $note->date }}" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="typeNote">Tipo</label>
					<select id="typeNote" class="form-control" disabled>
						@foreach($typesForm as $type)
							@if($type->id == $note->type_id)
								<option value="{{$group->token}}" selected>{{ converTitle($type->name) }}</option>
							@else
								<option value="{{$group->token}}">{{ converTitle($type->name) }}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>
			<div class="row text-center">
				<a href="{{route('ver-notas')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
				<a href="#" id="updateNote" data-url="notas" class="btn btn-success">Actualizar Nota</a>
			</div>
		</section>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection