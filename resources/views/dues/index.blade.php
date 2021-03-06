@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('page')
	<aside class="page">
		<h2>Cuotas de Afiliados</h2>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="table-data">
				<div class="table-header">
					<div class="row">
						<div class="col-sm-6">
							<h5><strong>Lista de Cuotas de Afiliados</strong></h5>
						</div>
						<div class="col-sm-6">
							<a data-url="cuotas" href="#" class="btn btn-info pull-right new">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
                        <input type="hidden" id="rec_priv" value="{{ recordPercentage()->percentage }}">
                        <input type="hidden" id="rec_affi" value="{{ recordPercentage()->percentage_affiliates }}">
                        <input type="hidden" id="token_rec" value="{{ recordPercentage()->token }}">
						<table id="table_dues" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%" style="table-layout:fixed;">
	                        <thead>
	                            <tr>
	                            	<th>Código</th>
	                                <th>Nombres</th>
	                                <th>Apellidos</th>
	                                <th>Mes</th>
	                                <th>Año</th>
	                                <th>Monto Empresa</th>
	                                <th>Monto Afiliado</th>
	                                <th>Sueldo</th>
	                                <th>Recibo</th>
	                                <th>Fecha del Recibo</th>
	                                <th>Edición</th>
	                                {{-- <th>Fecha del Último Aporte</th> --}}
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@if(count($dues) > 0)
		                        	@foreach($dues as $due)
			                            <tr>
			                            	<td class="text-center">{{ strtolower($due->affiliates->code) }}</td>
			                            	<td>{{ convertTitle($due->affiliates->name()) }}</td>
			                                <td>{{ convertTitle($due->affiliates->last()) }}</td>
			                                <td>{{ convertTitle(months()[$due->monthDue()]) }}</td>
			                                <td>{{ $due->yearDue() }}</td>
			                                @if($due->type == 'privado')
												<td class="text-center">{{ $due->amount  }}</td>
			                                @else
												<td class="text-center"></td>
			                                @endif
			                                @if($due->type == 'affiliate')
												<td class="text-center">{{ $due->amount  }}</td>
			                                @else
												<td class="text-center"></td>
			                                @endif
											<td class="text-center">{{ $due->salary }}</td>
											<td class="text-center">{{ $due->consecutive }}</td>
			                                <td class="text-center">{{ $due->dateDues() }}</td>
			                                <td class="text-center edit-row">
												<a class="edit" href="#" data-url="cuotas" data-token="{{$due->token}}"><i class="fa fa-pencil-square-o"></i></a>
			                                </td>
			                                {{-- <td class="text-center">{{ $due->datePayment() }}</td> --}}
			                            </tr>
		                            @endforeach
	                            @endif
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
	<script src="{{ asset('bower_components/handlebars/handlebars.min.js') }}"></script>
@endsection