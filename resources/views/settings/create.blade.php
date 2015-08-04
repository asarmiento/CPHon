@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Configuración</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Configuración</a></li>
				<li class="active-page"><a>Registrar Configuración</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="typeSeatSetting">Módulo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
                        <input  id="typeSeatSetting" class="form-control" value="{{ $typeSeat[0]->name }}" data-token="{{ $typeSeat[0]->token }}" type="text" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="catalogSetting">Cuenta</label>
					<select id="catalogSetting" class="form-control">
						@foreach($catalogs as $catalog)
							<option value="{{$catalog->token}}">{{ convertTitle($catalog->name) }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-configuracion')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="saveSetting" data-url="configuracion" class="btn btn-success">Guardar Configuración</a>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection