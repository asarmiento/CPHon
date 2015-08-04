@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Asientos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Asientos</a></li>
				<li class="active-page"><a>Ver Asientos</a></li>
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
							<h5><strong>Lista de Asientos</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-asientos')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_seatings" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                            	<th>Periodo Contable</th>
	                                <th>Fecha</th>
	                                <th>Código</th>
	                                <th>Crédito</th>
	                                <th>Debito</th>
	                                <th>Detalle</th>
	                                <th>Monto</th>
                                    <th>Reporte</th>
                                    <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($seatings as $seating)
		                            <tr>
		                            	<td class="text-center">{{ $seating->accountingPeriods->period() }}</td>
		                                <td class="text-center">{{ $seating->date }}</td>
		                                <td class="text-center">{{ $seating->code }}</td>
		                                @if($seating->types->name == 'credito')
											<td class="text-center">{{ convertTitle($seating->catalogs->name) }}</td>
											<td class="text-center"> - </td>
		                                @else
											<td class="text-center"> - </td>
											<td class="text-center">{{ convertTitle($seating->catalogs->name) }}</td>
		                                @endif
		                                <td class="text-center">{{ convertTitle($seating->detail) }}</td>
		                                <td class="text-center">{{ $seating->amount }}</td>
                                        <td class="text-center edit-row">
                                            <a target="_blank" href="{{route('ver-asientos', $seating->token)}}"><i class="fa fa-file-excel-o"></i></a>
                                        </td>
                                        <td class="text-center edit-row">
											<a href="{{route('asientos', $seating->token)}}"><i class="fa fa-eye"></i></a>
		                                </td>
		                            </tr>
	                            	@foreach($seatingsParts as $seatingPart)
										@if($seatingPart->seating_id == $seating->id)
										<tr>
											<td class="text-center">{{ $seatingPart->accountingPeriods->period() }}</td>
			                                <td class="text-center">{{ $seatingPart->date }}</td>
			                                <td class="text-center">{{ $seatingPart->code }}</td>
			                                @if($seatingPart->types->name == 'credito')
												<td class="text-center"> - </td>
												<td class="text-center">{{ convertTitle($seatingPart->catalogs->name) }}</td>
			                                @else
												<td class="text-center">{{ convertTitle($seatingPart->catalogs->name) }}</td>
												<td class="text-center"> - </td>
			                                @endif
			                                <td class="text-center">{{ convertTitle($seatingPart->detail) }}</td>
			                                <td class="text-center">{{ $seatingPart->amount }}</td>
	                                        <td class="text-center edit-row">
	                                            <a target="_blank" href="{{route('ver-asientos-excel', $seating->token)}}"><i class="fa fa-file-excel-o"></i></a>
	                                        </td>
	                                        <td class="text-center edit-row">
												<a href="{{route('asientos', $seating->token)}}"><i class="fa fa-eye"></i></a>
			                                </td>
										</tr>
										@endif
									@endforeach
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