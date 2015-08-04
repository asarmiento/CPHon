@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Periodos Contables</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Periodos Contables</a></li>
				<li class="active-page"><a>Ver Periodos Contables</a></li>
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
							<h5><strong>Lista de Periodos Contables</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-periodos-contables')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_accounting_period" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                                <th>Mes</th>
	                                <th>Año</th>
	                                <th>Periodo</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($accountingPeriods as $accountingPeriod)
		                            <tr>
		                                <td class="text-center" data-token="{{$accountingPeriod->token}}">{{ $accountingPeriod->month }}</td>
		                                <td class="text-center">{{ $accountingPeriod->year }}</td>
		                                <td class="text-center">{{ $accountingPeriod->period }}</td>
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