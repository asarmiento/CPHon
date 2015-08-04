@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Configuración</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Configuración</a></li>
				<li class="active-page"><a>Ver Configuración</a></li>
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
							<h5><strong>Lista de Configuración</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-configuracion')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_settings" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                            	<th>N°</th>
	                                <th>Módulo</th>
	                                <th>Cuenta</th>
                                    <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($settings as $key => $setting)
		                            <tr>
		                            	<td class="text-center">{{ ($key+1) }}</td>
		                            	<td class="text-center">{{ $setting->typeSeat->name }}</td>
		                                <td class="text-center">{{ $setting->catalogs->name }}</td>
                                        <td class="text-center edit-row">
											<a href="{{route('editar-configuracion',$setting->token)}}"><i class="fa fa-pencil-square-o"></i></a>
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