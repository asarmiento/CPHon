@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
@endsection

@section('page')
	<aside class="page">
		<h2>Costos de Mensualidad</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Costos de Mensualidad</a></li>
				<li class="active-page"><a>Registrar Costo de Mensualidad</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="yearCost">Año de la Mensualidad</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				      	<input id="yearCost" class="form-control" type="number" maxlenght="4">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="monthlyPaymentCost">Monto de la Mensualidad</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-usd"></i></span>
				      	<input id="monthlyPaymentCost" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="tuitionCost">Matrícula de la Mensualidad</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-usd"></i></span>
				      	<input id="tuitionCost" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="degreeSchoolCost">Grado de la Mensualidad</label>
					<select id="degreeSchoolCost" class="form-control">
						@foreach($degrees as $degree)
							<option value="{{$degree->token}}">{{ convertTitle($degree->name) }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-costos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="saveCost" data-url="costos" class="btn btn-success">Grabar Costo de Mensualidad</a>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection