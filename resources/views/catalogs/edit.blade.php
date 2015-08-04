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
				<li class="active-page"><a>Editar Catalógo</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="codeCatalog">Código del Catálogo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="codeCatalog" class="form-control" type="text" value="{{$catalog->code}}" data-token="{{$catalog->token}}" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameCatalog">Nombre del Catálogo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="nameCatalog" class="form-control" type="text" value="{{ convertTitle($catalog->name) }}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="styleCatalog">Estilo del Catálogo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
						<input id="styleCatalog" class="form-control" type="text" value="{{ convertTitle($catalog->style) }}" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="noteCatalog">Generación de Notas</label>
					<div class="row">
						@if($catalog->note == 'true')
			      			<input id="noteCatalog" type="checkbox" name="status-checkbox" data-on-text="Si" data-off-text="No" data-on-color="info" data-off-color="danger" data-label-text="Nota" checked>
			      		@else
							<input id="noteCatalog" type="checkbox" name="status-checkbox" data-on-text="Si" data-off-text="No" data-on-color="info" data-off-color="danger" data-label-text="Nota">
			      		@endif
			      	</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-catalogos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="updateCatalog" data-url="catalogos" class="btn btn-success">Actualizar Catálogo</a>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection