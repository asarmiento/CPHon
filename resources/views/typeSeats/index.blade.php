@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Tipos de Asientos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Tipos de Asientos</a></li>
				<li class="active-page"><a>Ver Tipos de Asientos</a></li>
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
							<h5><strong>Lista de Tipos de Asientos</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-tipos-de-asientos')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_type_seat" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                                <th>Abreviación</th>
	                                <th>Nombre</th>
	                                <th>Cantidad</th>
                                    <th>Año</th>
                                    <th>Institucion</th>
	                                <!--th>Edición</th-->
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($typeSeats as $typeSeat)
		                            <tr>
		                                <td class="text-center type_seat_abbreviation" data-token="{{$typeSeat->token}}">{{ convertTitle($typeSeat->abbreviation) }}</td>
		                                <td class="text-center type_seat_name">{{ convertTitle($typeSeat->name) }}</td>
		                                <td class="text-center type_seat_quantity">{{ $typeSeat->quatity }}</td>
		                                <td class="text-center type_seat_year">{{ $typeSeat->year }}</td>
                                        <td class="text-center type_seat_year">{{ $typeSeat->schools->name }}</td>
                                        <!--td class="text-center edit-row">
											<a href="{{route('editar-tipos-de-asientos', $typeSeat->token)}}"><i class="fa fa-pencil-square-o"></i></a>
		                                </td-->
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