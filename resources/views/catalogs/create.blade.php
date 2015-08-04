@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Catálogos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Catálogos</a></li>
				<li class="active-page"><a>Registrar Catálogo</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameCatalog">Nombre del Catálogo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="nameCatalog" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="styleCatalog">Estilo del Catálogo</label>
					<select id="styleCatalog" class="form-control">
						<option value="D">Detalle</option>
						<option value="G">Grupo</option>
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="levelCatalog">Nivel del Catálogo</label>
			      	<select id="levelCatalog" class="form-control" data-url="catalogos">
						@for($i = 2 ; $i <= 5; $i++)
							<option value="{{$i}}">{{$i}}</option>
						@endfor
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="groupCatalog">Grupo del Catálogo</label>
					<select id="groupCatalog" class="form-control">
						<option value="">- - Seleccione - -</option>
						@foreach($levels as $level)
							<option value="{{ $level->token }}">{{ convertTitle($level->name) }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="noteCatalog">Generación de Notas</label>
					<div class="row">
			      		<input id="noteCatalog" type="checkbox" name="status-checkbox"  data-off-text="No" data-on-text="Si" data-off-color="danger"  data-on-color="info" data-label-text="Nota" >
			      	</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-catalogos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="saveCatalog" data-url="catalogos" class="btn btn-success">Grabar Catálogo</a>
		</div>
	</div>
@stop

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection