@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Recibos Auxiliares</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Recibos Auxiliares</a></li>
				<li class="active-page"><a>Ver Recibo Auxiliar</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label>Periodo Contable</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                        <input class="form-control" value="{{ $auxiliaryReceipts[0]->accountingPeriods->period() }}" type="text" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label>N° de Reibo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input class="form-control" value="{{ $auxiliaryReceipts[0]->receipt_number }}" type="text" disabled>
                    </div>
				</div>
			</div>
		</section>
		<section>
			<div class="col-sm-12 col-md-12 table-responsive">
				<table id="table_auxiliar_seat_temp" class="table table-bordered table-hover Table" cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                        <tr class="Table-header">
                            <th class="text-center">Carnet</th>
                            <th class="text-center">Estudiante</th>
                        	<th class="text-center">Fecha</th>
                        	<th class="text-center">Monto Crédito</th>
                        </tr>
                        <tr class="Table-description">
                        	<th class="Table-description-is-header" colspan="4" class="text-center">Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                	@foreach($auxiliaryReceipts as $key => $auxiliaryReceipt)
						<tr class="Table-content">
							<td>{{ $auxiliaryReceipt->financialRecords->students->book }}</td>
							<td>{{ convertTitle($auxiliaryReceipt->financialRecords->students->nameComplete()) }}</td>
							<td class="text-center">{{ $auxiliaryReceipt->date }}</td>
							<td class="text-center">{{ $auxiliaryReceipt->amount }}</td>
						</tr>
						<tr class="Table-description">
							<td colspan="4">{{ convertTitle($auxiliaryReceipt->detail) }}</td>
						</tr>
                	@endforeach
                	<tr class="Table-accountStudent">
                		<td>00 - 00000</td>
                		<td>Control Alumnos</td>
                		<td class="text-center">{{ $auxiliaryReceipts[0]->date }}</td>
						<td class="text-center">{{ $total }}</td>
                	</tr>
                	<tr class="Table-total">
                		<td>Depositos N°: {{ $deposits_numbers }}</td>
                		<td>Elaborado por: {{ currentUser()->nameComplete()}}</td>
                		<td class="text-center">Total</td>
						<td class="text-center">{{ $total }}</td>
                	</tr>
                    </tbody>
                </table>
			</div>
		</section>
		<div id="btn-auxiliarySeat" class="row text-center">
			<a href="{{route('ver-recibos-auxiliares')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection