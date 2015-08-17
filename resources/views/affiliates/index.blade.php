@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('page')
	<aside class="page">
		<h2>Afiliados</h2>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="table-data">
				<div class="table-header">
					<div class="row">
						<div class="col-sm-6">
							<h5><strong>Lista de Afiliados</strong></h5>
						</div>
						<div class="col-sm-6">
							<a data-url="afiliados" href="#" class="btn btn-info pull-right new">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_affiliates" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%" style="table-layout:fixed;">
	                        <thead>
	                            <tr>
	                            	<th>Código</th>
	                            	<th>Cédula</th>
	                                <th>Nombres</th>
	                                <th>Apellidos</th>
	                                <th>Dirección</th>
	                                <th>Teléfono</th>
	                                <th>Fecha de Nacimiento</th>
	                                <th>Estado Civil</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@if(count($affiliates) > 0)
		                        	@foreach($affiliates as $affiliate)
			                            <tr>
			                            	<td class="text-center">{{ strtolower($affiliate->code) }}</td>
			                            	<td class="text-center">{{ strtolower($affiliate->charter) }}</td>
			                            	<td class="text-center">{{ convertTitle($affiliate->fname.' '.$affiliate->sname) }}</td>
			                                <td class="text-center">{{ convertTitle($affiliate->flast.' '.$affiliate->slast) }}</td>
			                                <td class="text-center">{{ convertTitle($affiliate->address) }}</td>
			                                <td class="text-center">{{ strtolower($affiliate->homePhone) }}</td>
			                                <td class="text-center">{{ strtolower($affiliate->birthdate) }}</td>
			                                <td class="text-center">{{ convertTitle($affiliate->maritalStatus) }}</td>
			                                <td class="text-center edit-row">
												<a class="edit" href="#" data-url="afiliados" data-token="{{$affiliate->token}}"><i class="fa fa-pencil-square-o"></i></a>
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
	<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}"></script>
	<script src="{{ asset('bower_components/handlebars/handlebars.min.js') }}"></script>
@endsection