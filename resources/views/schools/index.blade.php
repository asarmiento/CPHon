@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Institución</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Institución</a></li>
				<li class="active-page"><a>Ver Institución</a></li>
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
							<h5><strong>Lista de Instituciones</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-institucion')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_school" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                            	<th>Id</th>
	                                <th>Nombre</th>
	                                <th>Cédula</th>
	                                <th>Route</th>
	                                <th>Teléfono 1</th>
	                                <th>Teléfono 2</th>
	                                <th>Fax</th>
	                                <th>Dirección</th>
	                                <th>Ciudad</th>
	                                <th>Estado</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($schools as $school)
		                            <tr>
		                            	<td class="text-center school_number">{{$school->id}}</td>
		                                <td class="text-center school_name">{{convertTitle($school->name)}}</td>
		                                <td class="text-center school_charter">{{convertTitle($school->charter)}}</td>
		                                <td class="text-center school_route">{{convertTitle($school->route)}}</td>
		                                <td class="text-center school_phone_one">{{$school->phoneOne}}</td>
		                                <td class="text-center school_phone_two">{{$school->phoneTwo}}</td>
		                                <td class="text-center school_fax">{{$school->fax}}</td>
		                                <td class="text-center school_address">{{convertTitle($school->address)}}</td>
		                                <td class="text-center school_city">{{convertTitle($school->town)}}</td>
		                                <td class="text-center">
		                                	@if($school->deleted_at)
												<span>Inactivo</span>
		                                	@else
												<span>Activo</span>
		                                	@endif
		                                </td>
		                                <td class="text-center edit-row">
	                                		@if($school->deleted_at)
	                                			<a id="activeSchool" data-url="institucion" href="#">
	                                				<i class="fa fa-check-square-o"></i>
                                				</a>
	                                		@else
	                                			<a id="deleteSchool" data-url="institucion" href="#">
													<i class="fa fa-trash-o"></i>
												</a>
	                                		@endif
											<a href="{{route('editar-institucion', $school->id)}}"><i class="fa fa-pencil-square-o"></i></a>
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