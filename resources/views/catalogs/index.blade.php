@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Catálogos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Catálogos</a></li>
				<li class="active-page"><a>Ver Catálogos</a></li>
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
							<h5><strong>Lista de Catálogos</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-catalogos')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_catalogs" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                            	<th>Código</th>
	                                <th>Nombre</th>
	                                <th>Estilo</th>
	                                <th>Notas</th>
                                    <th>Estado Cuenta</th>
                                    <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($catalogs as $catalog)
		                            <tr>
		                                <td class="text-center catalog_code" data-token="{{$catalog->token}}">{{ $catalog->code }}</td>
		                                <td class="text-center">{{ convertTitle($catalog->name) }}</td>
		                                <td class="text-center">{{ convertTitle($catalog->style) }}</td>
		                                <td class="text-center edit-row">
	                                		@if($catalog->note == 'true')
	                                			Si
	                                		@else
	                                			No
	                                		@endif
	                                	</td>
                                        <td class="text-center edit-row">
                                            @if($catalog->style=='Detalle')
                                            <a target="_blank" href="{{route('ver-estado-de-cuenta', $catalog->token)}}"><i class="fa fa-file-excel-o"></i></a>
                                                @endif
                                        </td>
                                        <td class="text-center">
											<a href="{{route('editar-catalogos', $catalog->token)}}"><i class="fa fa-pencil-square-o"></i></a>
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