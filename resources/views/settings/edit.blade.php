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
				<li class="active-page"><a>Editar Configuración</a></li>
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
                        <input  id="typeSeatSetting" class="form-control" value="{{ $setting->typeSeat->name }}" data-token="{{ $setting->typeSeat->token }}" type="text" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="catalogSetting">Cuenta</label>
					<select id="catalogSetting" class="form-control" data-token="{{$setting->token}}">
						@foreach($catalogs as $catalog)
							@if($setting->catalog_id == $catalog->id)
								<option value="{{$catalog->token}}" selected>{{ convertTitle($catalog->name) }}</option>
							@else
								<option value="{{$catalog->token}}">{{ convertTitle($catalog->name) }}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-configuracion')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="updateSetting" data-url="configuracion" class="btn btn-success">Guardar Configuración</a>
		</div>
	</div>
@stop

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection