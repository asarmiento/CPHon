@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Asientos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Asientos</a></li>
				<li class="active-page"><a>Ver Asiento</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label>Periodo Contable</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                        <input class="form-control" value="{{ $seatings[0]->accountingPeriods->period() }}" type="text" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label>Código del Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input class="form-control" value="{{ $seatings[0]->code }}" type="text" disabled>
                    </div>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label>Total del Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input class="form-control" value="{{ $total }}" type="text" disabled>
                    </div>
				</div>
			</div>
		</section>
		<section>
			<div class="col-sm-12 col-md-12 table-responsive">
				<table id="table_auxiliar_seat_temp" class="table table-bordered table-hover Table" cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                        <tr class="Table-header">
                            <th class="text-center">Código</th>
                            <th class="text-center">Cuenta</th>
                        	<th class="text-center">Debito</th>
                        	<th class="text-center">Crédito</th>
                        </tr>
                        <tr class="Table-description">
                        	<th class="Table-description-is-header" colspan="4" class="text-center">Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                	@foreach($seatings as $key => $seating)
						<tr class="Table-content">
							<td>{{ convertTitle($seating->catalogs->code ) }}</td>
							<td>{{ convertTitle($seating->catalogs->name) }}</td>
							@if(strtolower($seating->types->name) == 'debito')
								<td class="text-center">{{ $seating->amount }}</td>
								<td class="text-center"> - </td>
							@else
								<td class="text-center"> - </td>
								<td class="text-center">{{ $seating->amount }}</td>
							@endif
						</tr>
						<tr class="Table-description">
							<td colspan="4">{{ convertTitle($seating->detail) }}</td>
						</tr>
						@foreach($seatingsParts as $seatingPart)
							@if($seatingPart->seating_id == $seating->id)
							<tr class="Table-description">
								<td>{{ $seatingPart->catalogs->code }}</td>
                                <td>{{ convertTitle($seatingPart->catalogs->name) }}</td>
                                @if($seatingPart->types->name == 'debito')
                                    <td class="text-center"> - </td>
									<td class="text-center">{{ $seatingPart->amount }}</td>
								@else
									<td class="text-center">{{ $seatingPart->amount }}</td>
                                    <td class="text-center"> - </td>
                                @endif
							</tr>
							@endif
						@endforeach
                	@endforeach
                	</tbody>
                </table>
			</div>
		</section>
		<div id="btn-seating" class="row text-center">
			<a href="{{route('ver-asientos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection