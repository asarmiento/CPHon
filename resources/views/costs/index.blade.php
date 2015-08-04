@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Costos de Mensulidad</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Costos de Mensulidad</a></li>
				<li class="active-page"><a>Ver Costos de Mensulidad</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="table-data">
				<div class="table-header">
					<div class="row">
						<div class="col-sm-6">
							<h5><strong>Lista de Costos de Mensulidad</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-costos')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_cost" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                                <th>Año</th>
	                                <th>Monto</th>
	                                <th>Matrícula</th>
	                                <th>Grado</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($costs as $cost)
		                            <tr>
		                                <td class="text-center cost_year" data-token="{{$cost->token}}">{{ $cost->year }}</td>
		                                <td class="text-center cost_monthly_payment">{{ $cost->monthly_payment }}</td>
		                                <td class="text-center cost_tuition">{{ $cost->tuition }}</td>
		                                <td class="text-center cost_degree_chool">{{$cost->degreeSchool->degrees->name}}</td>
		                                <td class="text-center edit-row">
											<a href="{{route('editar-costos', $cost->token)}}"><i class="fa fa-pencil-square-o"></i></a>
		                                </td>
		                            </tr>
	                            @endforeach
	                        </tbody>
	                    </table>
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/datatables-bootstrap3-plugin/media/js/datatables-bootstrap3.min.js') }}"></script>
@endsection