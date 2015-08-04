@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Recibos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Recibos</a></li>
				<li class="active-page"><a>Ver Recibos</a></li>
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
							<h5><strong>Lista de Recibos</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-recibos')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_receipts" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                            	<th>Fecha</th>
	                                <th>N° de Recibo</th>
	                                <th>Detalle</th>
	                                <th>Monto</th>
	                                <th>Cuenta</th>
	                                <th>Recibido Por</th>
	                                <th>Periodo Contable</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($receipts as $receipt)
		                            <tr>
		                            	<td class="text-center auxiliary_seat_date" data-token="">{{ $receipt->date }}</td>
		                                <td class="text-center">{{ $receipt->receipt_number }}</td>
		                                <td class="text-center">{{ convertTitle($receipt->detail) }}</td>
		                                <td class="text-center">{{ $receipt->amount }}</td>
		                                <td class="text-center">{{ convertTitle($receipt->catalogs->codeName() ) }}</td>
		                                <td class="text-center">{{ convertTitle($receipt->received_from) }}</td>
		                                <td class="text-center">{{ $receipt->accountingPeriods->period() }}</td>
		                                <td class="text-center edit-row">
											<a href="{{route('recibos', $receipt->token)}}"><i class="fa fa-eye"></i></a>
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
@endsection