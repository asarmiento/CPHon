@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Roles</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Roles</a></li>
				<li class="active-page"><a>Ver Roles</a></li>
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
							<h5><strong>Lista de Roles de Usuarios</strong></h5>		
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_role" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                            	<th>Código</th>
	                                <th>Nombre</th>
	                                <th>Apellido</th>
	                                <th>Email</th>
	                                <th>Tipo de Usuario</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($users as $user)
		                            <tr>
		                            	<td class="text-center user_number">{{$user->id}}</td>
		                                <td class="text-center user_name">{{ convertTitle($user->name) }}</td>
		                                <td class="text-center user_last">{{ convertTitle($user->last) }}</td>
		                                <td class="text-center user_email">{{ strtolower($user->email) }}</td>
		                                <td class="text-center user_type_user">{{ convertTitle($user->typeUsers->name)}}</td>
		                                <td class="text-center edit-row">
											<a href="{{route('editar-roles', $user->id)}}"><i class="fa fa-pencil-square-o"></i></a>
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
@stop

@section('scripts')
	<script src="{{ asset('bower_components/datatables-bootstrap3-plugin/media/js/datatables-bootstrap3.min.js') }}"></script>
@endsection