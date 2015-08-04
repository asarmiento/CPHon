@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Recibos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Recibos</a></li>
				<li class="active-page"><a>Registrar Recibo</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label for="accoutingPeriodReceipt">Periodo Contable</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				      	<input id="accoutingPeriodReceipt" class="form-control" type="text" value="{{ period() }}" data-token="{{periodSchool()->token}}" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label for="dateReceipt">Fecha del Recibo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				      	<input id="dateReceipt" class="form-control" type="text" value="{{dateShort()}}" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label for="receiptNumberReceipt">Número de Recibo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="receiptNumberReceipt" class="form-control" value="{{$typeSeat[0]->abbreviation.'-'.$typeSeat[0]->quatity}}"  data-token="{{$typeSeat[0]->token}}" type="text" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="receivedFromReceipt">Recibido Por</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
                        @if(count($receipts) == 0)
                            <input id="receivedFromReceipt" class="form-control" type="text">
                        @else
                            <input id="receivedFromReceipt" class="form-control" value="{{$receipts[0]->received_from}}" type="text">
                        @endif

					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="detailReceipt">Detalle del Recibo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="detailReceipt" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="amountReceipt">Monto del Recibo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-usd"></i></span>
				      	<input id="amountReceipt" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="catalogReceipt">Cuenta</label>
					<select id="catalogReceipt" class="form-control">
						@foreach($catalogs as $catalog)
                        	<option value="{{$catalog->token}}" data-code="{{$catalog->code}}" data-name="{{convertTitle($catalog->name)}}">{{ $catalog->code . ' - '.convertTitle($catalog->name) }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<a id="saveDetailReceipt" href="#" class="btn btn-info" data-url="recibos" style="margin-top:1.5em;">
						<i class="fa fa-floppy-o"></i> Grabar Recibo
					</a>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="totalReceipt">Total del Recibo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-usd"></i></span>
						@if(count($receipts) == 0)
				      		<input id="totalReceipt" class="form-control" type="number" value="0.00" disabled>
				      	@else
							<input id="totalReceipt" class="form-control" type="number" value="{{$total}}" disabled>
				      	@endif
					</div>
				</div>
			</div>
		</section>
		<section>
			<div class="col-sm-12 col-md-12 table-responsive">
				@if(count($receipts) > 0)
					<table id="table_receipt_temp" class="table table-bordered Table" cellpadding="0" cellspacing="0" border="0" width="100%">
				@else
					<table id="table_receipt_temp" class="table table-bordered Table hide" cellpadding="0" cellspacing="0" border="0" width="100%">
				@endif
                    <thead>
                        <tr class="Table-header">
                            <th class="text-center">Código</th>
                            <th class="text-center">Cuenta</th>
                            <th class="text-center">Monto</th>
                            <th class="text-center">Eliminar</th>
                        </tr>
                        <tr class="Table-description">
                        	<th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($receipts) > 0)
                    	@foreach($receipts as $key => $receipt)
                    		@if($key == 0)
								<input id="tokenReceipt" type="hidden" value="{{ $receipt->token }}">
                    		@endif
							<tr class="Table-content">
								<td>{{ $receipt->catalogs->code }}</td>
								<td>{{ convertTitle($receipt->catalogs->name) }}</td>
								<td class="text-center">{{ $receipt->amount }}</td>
								<td class="text-center">
									<a href="#" id="deleteReceipt" data-url="recibos" data-id="{{$receipt->id}}">
										<i class="fa fa-trash-o"></i>
									</a>
								</td>
							</tr>
							<tr class="Table-description">
								<td colspan="4">{{ convertTitle($receipt->detail) }}</td>
							</tr>
                    	@endforeach
                    @endif
                    </tbody>
                </table>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-recibos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			@if(count($receipts) > 0)
				<a href="#" id="saveReceipt" data-url="recibos" class="btn btn-success">Aplicar Recibo Auxiliar</a>
			@else
				<a href="#" id="saveReceipt" data-url="recibos" class="btn btn-success hide">Aplicar Recibo Auxiliar</a>
			@endif
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection