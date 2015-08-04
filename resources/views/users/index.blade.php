@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Usuarios</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Usuarios</a></li>
				<li class="active-page"><a>Ver Usuarios</a></li>
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
							<h5><strong>Lista de Usuarios</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-usuarios')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_user" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                            	<th>Código</th>
	                                <th>Nombre</th>
	                                <th>Apellido</th>
	                                <th>Email</th>
	                                <th>Tipo de Usuario</th>
	                                <th>Estado</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($users as $user)
		                            <tr>
		                            	<td class="text-center user_number">{{$user->id}}</td>
		                                <td class="text-center user_name">{{mb_convert_case($user->name, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center user_last">{{mb_convert_case($user->last, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center user_email">{{strtolower($user->email)}}</td>
		                                <td class="text-center user_type_user">
		                                	<span>{{mb_convert_case($user->typeUsers->name, MB_CASE_TITLE, 'utf-8')}}</span>
	                                	</td>
		                                <td class="text-center">
		                                	@if($user->deleted_at)
												<span>Inactivo</span>
		                                	@else
												<span>Activo</span>
		                                	@endif
		                                </td>
		                                <td class="text-center edit-row">
	                                		@if($user->deleted_at)
	                                			<a id="activeUser" data-url="usuarios" href="#">
	                                				<i class="fa fa-check-square-o"></i>
                                				</a>
	                                		@else
	                                			<a id="deleteUser" data-url="usuarios" href="#">
													<i class="fa fa-trash-o"></i>
												</a>
	                                		@endif
											<a href="{{route('editar-usuarios', $user->id)}}"><i class="fa fa-pencil-square-o"></i></a>
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