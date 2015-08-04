@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Asientos Auxiliares</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Asientos Auxiliares</a></li>
				<li class="active-page"><a>Registrar Asiento Auxiliar</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label for="accoutingPeriodAuxiliarySeat">Periodo Contable</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                        <input  id="accoutingPeriodAuxiliarySeat" class="form-control" value="{{period()}}" type="text" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label for="dateAuxiliarySeat">Fecha del Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				      	<input id="dateAuxiliarySeat" class="form-control" type="text" value="{{dateShort()}}" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
				<div class="form-mep">
					<label for="codeAuxiliarySeat">Código del Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="codeAuxiliarySeat" class="form-control" value="{{$typeSeat[0]->abbreviation.'-'.$typeSeat[0]->quatity}}" type="text" data-token="{{$typeSeat[0]->token}}" disabled>
                    </div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="financialRecordAuxiliarySeat">Estudiante</label>
					<select id="financialRecordAuxiliarySeat" class="form-control">
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
					<label for="detailAuxiliarySeat">Detalle del Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="detailAuxiliarySeat" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="amountAuxiliarySeat">Monto del Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-usd"></i></span>
				      	<input id="amountAuxiliarySeat" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="typeAuxiliarySeat">Tipo de Asiento</label>
					@if(count($auxiliarySeats) > 0)
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tag"></i></span>
					      	<input id="typeAuxiliarySeat" class="form-control" type="text" value="{{ convertTitle($auxiliarySeats[0]->types->name) }}" data-type="text" data-token="{{$auxiliarySeats[0]->types->token}}" disabled>
						</div>		
					@else
						<select id="typeAuxiliarySeat" class="form-control" data-type="select">
						@foreach($types as $type)
							<option value="{{$type->token}}">{{ convertTitle($type->name) }}</option>
						@endforeach
						</select>
					@endif
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<a id="saveDetailAuxiliarySeat" href="#" class="btn btn-info" data-url="asientos-auxiliares" style="margin-top:1.5em;">
						<i class="fa fa-floppy-o"></i> Grabar Estudiante
					</a>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="totalAuxiliarySeat">Total del Asiento</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-usd"></i></span>
						@if(count($auxiliarySeats) == 0)
				      		<input id="totalAuxiliarySeat" class="form-control" type="number" value="0.00" disabled>
				      	@else
							<input id="totalAuxiliarySeat" class="form-control" type="number" value="{{$total}}" disabled>
				      	@endif
					</div>
				</div>
			</div>
		</section>
		<section>
			<div class="col-sm-12 col-md-12 table-responsive">
				@if(count($auxiliarySeats) > 0)
					<table id="table_auxiliar_seat_temp" class="table table-bordered table-hover Table" cellpadding="0" cellspacing="0" border="0" width="100%">
				@else
					<table id="table_auxiliar_seat_temp" class="table table-bordered table-hover Table hide" cellpadding="0" cellspacing="0" border="0" width="100%">
				@endif
                    <thead>
                        <tr class="Table-header">
                            <th class="text-center">Carnet</th>
                            <th class="text-center">Estudiante</th>
                            <th class="text-center">Detalle</th>
                            <th class="text-center">Tipo de Asiento</th>
                            <th class="text-center">Monto</th>
                            <th class="text-center">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($auxiliarySeats) > 0)
                    	@foreach($auxiliarySeats as $key => $auxiliarySeat)
                    		@if($key == 0)
								<input id="tokenAuxiliarySeat" type="hidden" value="{{ $auxiliarySeat->token }}">
                    		@endif
							<tr class="Table-content">
								<td>{{ $auxiliarySeat->financialRecords->students->book }}</td>
								<td>{{ convertTitle($auxiliarySeat->financialRecords->students->nameComplete()) }}</td>
								<td>{{ convertTitle($auxiliarySeat->detail) }}</td>
								<td>{{ convertTitle($auxiliarySeat->types->name) }}</td>
								<td>{{ $auxiliarySeat->amount }}</td>
								<td class="text-center">
									<a href="#" id="deleteDetailRow" data-url="asientos-auxiliares" data-id="{{$auxiliarySeat->id}}">
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
		<div id="btn-auxiliarySeat" class="row text-center">
			<a href="{{route('ver-asientos-auxiliares')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			@if(count($auxiliarySeats) > 0)
				<a href="#" id="saveAuxiliarySeat" data-url="asientos-auxiliares" class="btn btn-success">Aplicar Asiento Auxiliar</a>
			@else
				<a href="#" id="saveAuxiliarySeat" data-url="asientos-auxiliares" class="btn btn-success hide">Aplicar Asiento Auxiliar</a>
			@endif
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}"></script>
@endsection