@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Cortes de Caja</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Cortes de Caja</a></li>
				<li class="active-page"><a>Registrar Corte de Caja</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="accoutingPeriodAuxiliarySeat">Periodo Contable</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                        <input  id="accoutingPeriodAuxiliarySeat" class="form-control" value="{{period()}}" type="text" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="dateAuxiliarySeat">Fecha del Corte</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				      	<input id="dateAuxiliarySeat" class="form-control" type="text" value="{{dateShort()}}" disabled>
					</div>
				</div>
			</div>
		</section>
		<section>
			@if( count($auxiliaryReceipts) > 0 || count($receipts) > 0 )
				<div class="col-sm-12 col-md-12 table-responsive">
					<table id="table_auxiliar_seat_temp" class="table table-bordered table-hover Table" cellpadding="0" cellspacing="0" border="0" width="100%">
	                    <thead>
	                        <tr class="Table-header">
	                            <th class="text-center">Tipo</th>
	                            <th class="text-center">Código</th>
	                            <th class="text-center">Cuenta</th>
	                            <th class="text-center">Crédito</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	<?php $total = 0; ?>
	                    	@foreach($auxiliaryReceipts as $key => $auxiliaryReceipt)
								<tr class="Table-content">
									<td>{{ $auxiliaryReceipt->receipt_number }}</td>
									<td>{{ $auxiliaryReceipt->financialRecords->students->book }}</td>
									<td>{{ convertTitle($auxiliaryReceipt->financialRecords->students->nameComplete()) }}</td>
									<td class="text-center">{{ $auxiliaryReceipt->amount }}</td>
									<?php $total += $auxiliaryReceipt->amount ?>
								</tr>
	                    	@endforeach
	                    	@foreach($receipts as $key => $receipt)
								<tr class="Table-content">
									<td>{{ $receipt->receipt_number }}</td>
									<td>{{ $receipt->catalogs->code }}</td>
									<td>{{ convertTitle($receipt->catalogs->name) }}</td>
									<td class="text-center">{{ $receipt->amount }}</td>
									<?php $total += $receipt->amount ?>
								</tr>
	                    	@endforeach
	                    	<tr class="Table-total">
								<td></td>
								<td><span class="pull-right">Depositos</span></td>
								<td class="text-center">{{ $sum_deposits }}</td>
								<td class="text-center"></td>
							</tr>
							<tr class="Table-total">
								<td></td>
								<td><span class="pull-right">Efectivo</span></td>
								<td class="text-center">{{ $sum_cashes }}</td>
								<td class="text-center"></td>
							</tr>
							<tr class="Table-total">
								<td></td>
								<td><span class="pull-right">Total</span></td>
								<td class="text-center">{{ $sum_total }}</td>
								<td class="text-center">{{ $total }}</td>
							</tr>
	                    </tbody>
	                </table>
				</div>
			@else
				<div class="col-sm-12 col-md-12 text-center">
					<h3>Aún no se han registrados Recibos.</h3>
				</div>
			@endif
		</section>
		<div class="row text-center">
			<a href="{{route('ver-cortes-de-caja')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			@if( count($auxiliaryReceipts) > 0 || count($receipts) > 0 )
				<a href="#" id="saveCourtCase" data-url="cortes-de-caja" class="btn btn-success">Aplicar Corte de Caja</a>
			@else
				<a href="#" id="saveCourtCase" data-url="cortes-de-caja" class="btn btn-success hide">Aplicar Corte de Caja</a>
			@endif
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection