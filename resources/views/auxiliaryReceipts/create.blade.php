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
				<li class="active-page"><a>Registrar Recibo Auxiliar</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label for="accoutingPeriodAuxiliaryReceipt">Periodo Contable</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="accoutingPeriodAuxiliaryReceipt" class="form-control" type="text" value="{{period()}}" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label for="dateAuxiliaryReceipt">Fecha del Recibo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				      	<input id="dateAuxiliaryReceipt" class="form-control" type="text" value="{{dateShort()}}" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label for="receiptNumberAuxiliaryReceipt">Número de Recibo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="receiptNumberAuxiliaryReceipt" class="form-control" value="{{$typeSeat[0]->abbreviation.'-'.$typeSeat[0]->quatity}}"  data-token="{{$typeSeat[0]->token}}" type="text" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="receivedFromAuxiliaryReceipt">Recibido Por</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="receivedFromAuxiliaryReceipt" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="detailAuxiliaryReceipt">Detalle del Recibo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="detailAuxiliaryReceipt" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="amountAuxiliaryReceipt">Monto del Recibo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-usd"></i></span>
				      	<input id="amountAuxiliaryReceipt" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="financialRecordAuxiliaryReceipt">Estudiante</label>
					<select id="financialRecordAuxiliaryReceipt" class="form-control">
						@foreach($financialRecords as $financialRecord)
							@if($financialRecord->students->school_id == userSchool()->id)
                            	<option value="{{$financialRecord->students->token}}">{{ $financialRecord->students->book.' - '. convertTitle($financialRecord->students->nameComplete()) }}</option>
                            @endif
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<a id="saveDetailAuxiliaryReceipt" href="#" class="btn btn-info" data-url="recibos-auxiliares" style="margin-top:1.5em;">
						<i class="fa fa-floppy-o"></i> Grabar Estudiante
					</a>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="totalAuxiliaryReceipt">Total del Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-usd"></i></span>
						@if(count($auxiliaryReceipts) == 0)
				      		<input id="totalAuxiliaryReceipt" class="form-control" type="number" value="0.00" disabled>
				      	@else
							<input id="totalAuxiliaryReceipt" class="form-control" type="number" value="{{$total}}" disabled>
				      	@endif
					</div>
				</div>
			</div>
		</section>
		<section>
			<div class="col-sm-12 col-md-12 table-responsive">
				@if(count($auxiliaryReceipts) > 0)
					<table id="table_auxiliar_receipt_temp" class="table table-bordered Table" cellpadding="0" cellspacing="0" border="0" width="100%">
				@else
					<table id="table_auxiliar_receipt_temp" class="table table-bordered Table hide" cellpadding="0" cellspacing="0" border="0" width="100%">
				@endif
                    <thead>
                        <tr class="Table-header">
                            <th class="text-center">Carnet</th>
                            <th class="text-center">Estudiante</th>
                            <th class="text-center">Detalle</th>
                            <th class="text-center">Monto</th>
                            <th style="text-align:center !important; padding-left:0;">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($auxiliaryReceipts) > 0)
                    	@foreach($auxiliaryReceipts as $key => $auxiliaryReceipt)
                    		@if($key == 0)
								<input id="tokenAuxiliaryReceipt" type="hidden" value="{{ $auxiliaryReceipt->token }}">
                    		@endif
							<tr class="Table-content">
								<td>{{ $auxiliaryReceipt->financialRecords->students->book }}</td>
								<td>{{ convertTitle($auxiliaryReceipt->financialRecords->students->nameComplete()) }}</td>
								<td>{{ convertTitle($auxiliaryReceipt->detail) }}</td>
								<td class="text-center">{{ $auxiliaryReceipt->amount }}</td>
								<td class="text-center">
									<a href="#" id="deleteReceiptRow" data-url="recibos-auxiliares" data-id="{{$auxiliaryReceipt->id}}">
										<i class="fa fa-trash-o"></i>
									</a>
								</td>
							</tr>
                    	@endforeach
                    @endif
                    </tbody>
                </table>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-recibos-auxiliares')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			@if(count($auxiliaryReceipts) > 0)
				<a href="#" id="saveAuxiliaryReceipt" data-url="recibos-auxiliares" class="btn btn-success" data-toggle="modal" target=".modal-receipt">Aplicar Recibo Auxiliar</a>
			@else
				<a href="#" id="saveAuxiliaryReceipt" data-url="recibos-auxiliares" class="btn btn-success hide" data-toggle="modal" target=".modal-receipt">Aplicar Recibo Auxiliar</a>
			@endif
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection