@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
@endsection

@section('page')
	<aside class="page">
		<h2>Menú</h2>
		<div class="list-inline-block">
			<ul>
				<li class="active-page"><a>Porcentajes</a></li>
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
							<h5><strong>Lista de Porcentajes</strong></h5>
						</div>
						<div class="col-sm-6">
							<a data-url="porcentajes" href="#" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_porcent" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%" style="table-layout:fixed;">
	                        <thead>
	                            <tr>
	                                <th>Año</th>
	                                <th>Mes</th>
	                                <th>Porcentaje del Afiliado</th>
	                                <th>Porcentaje de la Empresa</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@if(count($recordPercentages) > 0)
		                        	@foreach($recordPercentages as $recordPercentage)
			                            <tr>
			                            	<td>{{ strtolower($recordPercentage->year) }}</td>
			                            	<td>{{ strtolower($recordPercentage->month) }}</td>
			                                <td>{{ strtolower($recordPercentage->percentage_affiliates) }}</td>
			                                <td>{{ strtolower($recordPercentage->percentage) }}</td>
			                                <td class="text-center edit-row">
												<a href="#" data-url="porcentajes"><i class="fa fa-pencil-square-o"></i></a>
			                                </td>
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
@endsection