@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Corte de Caja</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Cortes de Caja</a></li>
				<li class="active-page"><a>Ver Corte de Caja</a></li>
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
							<h5><strong>Lista de Cortes de Caja</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-costos')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_courtCase" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                                <th>Fecha</th>
	                                <th>Numero de Corte</th>
	                                <th>Reporte</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($courtCases as $courtCase) 
		                            <tr>
		                                <td class="text-center cost_year" data-token="{{$courtCase->token}}">{{ $courtCase->date }}</td>
		                                <td class="text-center cost_monthly_payment">{{ $courtCase->abbreviation }}</td>
		                                <td class="text-center edit-row">
	                                		<a id="reportCourtCase" href="{{route('impresion-cortes-de-caja', $courtCase->token)}}"><i class="fa fa-file-pdf-o"></i></a>
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