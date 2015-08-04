@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Asientos Auxiliares</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Asientos Auxiliares</a></li>
				<li class="active-page"><a>Ver Asientos Auxiliares</a></li>
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
							<h5><strong>Lista de Asientos Auxiliares</strong></h5>
						</div>
						<div class="col-sm-6">
							<a id="otherPeriods" data-url="asientos-auxiliares" href="#" class="btn btn-default pull-left">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Cobro - Otros Periodos</span>
							</a>
							<a href="{{route('crear-asientos-auxiliares')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_auxiliary_seat" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                            	<th>Fecha</th>
	                                <th>Código</th>
	                                <th>Detalle</th>
	                                <th>Monto</th>
	                                <th>Estudiante</th>
	                                <th>Periodo Contable</th>
	                                <th>Tipo</th>
                                    <th>Reporte</th>
                                    <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($auxiliarySeats as $auxiliarySeat)
		                            <tr>
		                            	<td class="text-center auxiliary_seat_date" data-token="">{{ $auxiliarySeat->date }}</td>
		                                <td class="text-center">{{ convertTitle($auxiliarySeat->code) }}</td>
		                                <td class="text-center">{{ convertTitle($auxiliarySeat->detail) }}</td>
		                                <td class="text-center">{{ $auxiliarySeat->amount }}</td>
		                                <td class="text-center">{{ $auxiliarySeat->financialRecords->students->book.' - '.convertTitle($auxiliarySeat->financialRecords->students->nameComplete()) }}</td>
		                                <td class="text-center">{{ $auxiliarySeat->accountingPeriods->period() }}</td>
		                                <td class="text-center">{{ convertTitle($auxiliarySeat->types->name) }}</td>
                                        <td class="text-center edit-row">
                                            <a target="_blank" href="{{route('ver-asientos-auxiliary', $auxiliarySeat->token)}}"><i class="fa fa-file-excel-o"></i></a>
                                        </td>
                                        <td class="text-center edit-row">
											<a href="{{route('asientos-auxiliares', $auxiliarySeat->token)}}"><i class="fa fa-eye"></i></a>
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
	<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}"></script>
@endsection