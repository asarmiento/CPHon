@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
@endsection

@section('page')
	<aside class="page">
		<h2>Menú</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Menú</a></li>
				<li class="active-page"><a>Ver Menú</a></li>
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
							<h5><strong>Lista de Menú</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-menu')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_menu" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%" style="table-layout:fixed;">
	                        <thead>
	                            <tr>
	                                <th>Código</th>
	                                <th>Nombre</th>
	                                <th>Url</th>
	                                @foreach($tasks as $task)
										<th>{{$task->name}}</th>
	                                @endforeach
	                                <th>Estado</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($menus as $menu)
		                            <tr>
		                                <td class="text-center menu_number">{{$menu->id}}</td>
		                                <td class="menu_name">{{strtolower($menu->name)}}</td>
		                                <td class="menu_url">{{strtolower($menu->url)}}</td>
			                            @foreach($menu->Tasks as $taskMenu)
		                                	@if($taskMenu->pivot->status == 0)
		                                		<td class="text-center">-</td>
		                                	@else
		                                		<td class="text-center"><span class="glyphicon glyphicon-ok"></span></td>
		                                	@endif
		                                @endforeach
		                                <td class="text-center">
		                                	@if($menu->deleted_at)
												<span>Inactivo</span>
		                                	@else
												<span>Activo</span>
		                                	@endif
		                                </td>
		                                <td class="text-center edit-row">
	                                		@if($menu->deleted_at)
	                                			<a id="activeMenu" data-url="menu" href="#">
	                                				<i class="fa fa-check-square-o"></i>
                                				</a>
	                                		@else
	                                			<a id="deleteMenu" data-url="menu" href="#">
													<i class="fa fa-trash-o"></i>
												</a>
	                                		@endif
											<a href="{{route('editar-menu', $menu->id)}}"><i class="fa fa-pencil-square-o"></i></a>
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