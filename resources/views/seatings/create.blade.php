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
				<li class="active-page"><a>Registrar Asiento</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label for="accoutingPeriodSeating">Periodo Contable</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                        <input  id="accoutingPeriodSeating" class="form-control" value="{{period()}}" data-token="{{periodSchool()->token}}" type="text" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label for="dateSeating">Fecha del Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				      	<input id="dateSeating" class="form-control" type="text" value="{{dateShort()}}" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label for="typeSeatSeating">Código del Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="typeSeatSeating" class="form-control" value="{{$typeSeat[0]->abbreviation.'-'.$typeSeat[0]->quatity}}" type="text" data-token="{{$typeSeat[0]->token}}" disabled>
                    </div>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label for="accountSeating">Cuenta</label>
					<select id="accountSeating" class="form-control" data-type="select">
                        @if($catalogs->isEmpty())
                            <option value="">No existen cuentas contables</option>
                        @endif
					@foreach($catalogs as $catalog)
                        <option value="{{$catalog->token}}">{{ $catalog->code.' '.convertTitle($catalog->name) }}</option>
					@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label for="typeSeating">Tipo de Asiento</label>
					<select id="typeSeating" class="form-control" data-type="select">
					@foreach($types as $type)
						<option value="{{$type->token}}">{{ convertTitle($type->name) }}</option>
					@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label for="detailSeating">Detalle del Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="detailSeating" class="form-control" type="text">
					</div>
				</div>
			</div>

			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label>Cuenta de Contraparte - Monto</label>
					<div class="row accountPart">
						<aside class="row" style="margin-bottom: .5em;">
							<div class="col-sm-9" style="padding:0;">
								<select class="form-control accountPartSeating" data-type="select">
								@if($catalogs->isEmpty())
		                            <option value="">No existen cuentas contables</option>
		                        @else
									@foreach($catalogs as $catalog)
										<option value="{{$catalog->token}}">{{ $catalog->code.' '.convertTitle($catalog->name) }}</option>
									@endforeach
								@endif
								</select>
							</div>
							<div class="col-sm-3" style="padding-right:0;">
								<input class="form-control amountSeating" type="number">
							</div>
						</aside>
					</div>
					<button id="addPartSeating" class="btn btn-info" style="margin-top:.5em;">Agregar Cuenta</button>
					<button id="removePartSeating" class="btn btn-danger hide" style="margin-top:.5em;">Eliminar Cuenta</button>
					<a id="saveDetailSeating" href="#" class="btn btn-success" data-url="asientos" style="margin-top:.5em;">
						<i class="fa fa-floppy-o"></i> Grabar Asiento
					</a>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="totalSeating">Total del Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-usd"></i></span>
						@if(count($seatings) == 0)
				      		<input id="totalSeating" class="form-control" type="number" value="0.00" disabled>
				      	@else
							<input id="totalSeating" class="form-control" type="number" value="{{$total}}" disabled>
				      	@endif
					</div>
				</div>
			</div>
		</section>
		<section>
			<div class="col-sm-12 col-md-12 table-responsive">
				@if(count($seatings) > 0)
					<table id="table_seating_temp" class="table table-bordered table-hover Table" cellpadding="0" cellspacing="0" border="0" width="100%">
				@else
					<table id="table_seating_temp" class="table table-bordered table-hover Table hide" cellpadding="0" cellspacing="0" border="0" width="100%">
				@endif
                    <thead>
                        <tr class="Table-header">
                            <th class="text-center">Código</th>
                            <th class="text-center">Cuenta</th>
                            <th class="text-center">Debito</th>
                            <th class="text-center">Crédito</th>
                            <th class="text-center">Eliminar</th>
                        </tr>
                        <tr class="Table-description">
                        	<th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($seatings) > 0)
                    	@foreach($seatings as $key => $seating)
                    		@if($key == 0)
								<input id="tokenSeating" type="hidden" value="{{ $seating->token }}">
                    		@endif
							<tr class="Table-content">
                                <td>{{ ($seating->catalogs->code) }}</td>
                                <td>{{ convertTitle($seating->catalogs->name) }}</td>
								@if($seating->types->name == 'DEBITO')
									<td class="text-center">{{ $seating->amount }}</td>
									<td class="text-center"> - </td>
								@elseif($seating->types->name == 'CREDITO')
									<td class="text-center"> - </td>
									<td class="text-center">{{ $seating->amount }}</td>
								@endif
								<td class="text-center">
									<a href="#" id="deleteDetailSeating" data-url="asientos" data-id="{{$seating->id}}" data-class="{{ $key }}">
										<i class="fa fa-trash-o"></i>
									</a>
								</td>
							</tr>
                            <tr class="Table-description {{ $key }}">
                                <td>{{ convertTitle($seating->detail) }}</td>
                            </tr>
							@foreach($seatingsParts as $seatingPart)
								@if($seatingPart->seating_id == $seating->id)
								<tr class="Table-description {{ $key }}">
									<td>{{ $seatingPart->catalogs->code }}</td>
									<td>{{ convertTitle($seatingPart->catalogs->name) }}</td>
									@if($seatingPart->types->name == 'DEBITO')
									<td class="text-center">{{ $seatingPart->amount }}</td>
										<td class="text-center"> - </td>
									@elseif($seatingPart->types->name == 'CREDITO')
										<td class="text-center"> - </td>
										<td class="text-center">{{ $seatingPart->amount }}</td>
										
									@endif
								</tr>
								@endif
							@endforeach
                    	@endforeach

                    @endif
                    </tbody>
                </table>
			</div>
		</section>
		<div id="btn-seating" class="row text-center">
			<a href="{{route('ver-asientos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			@if(count($seatings) > 0)
				<a href="#" id="saveSeating" data-url="asientos" class="btn btn-success">Aplicar Asiento</a>
			@else
				<a href="#" id="saveSeating" data-url="asientos" class="btn btn-success hide">Aplicar Asiento</a>
			@endif
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection