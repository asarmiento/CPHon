@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Estudiantes</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Estudiantes</a></li>
				<li class="active-page"><a>Ver Estudiantes Matriculados</a></li>
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
							<h5><strong>Lista de Estudiantes Matriculados</strong></h5>		
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-estudiante')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_student_enrolled" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                                <th>Nombres</th>
	                                <th>Apellidos</th>
	                                <th>Sexo</th>
	                                <th>Teléfono</th>
	                                <th>Dirección</th>
	                                <th>Grado</th>
	                                <th>Descuento a la Matrícula</th>
	                                <th>Descuento a la Mensualidad</th>
	                                <th>Saldo</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($finantialRecords as $finantialRecord)
	                        		@if($finantialRecord->students->school_id == userSchool()->id)
		                            <tr>
		                                <td class="text-center student_name">{{ convertTitle($finantialRecord->students->fname.' '.$finantialRecord->students->sname) }}</td>
		                                <td class="text-center student_last">{{ convertTitle($finantialRecord->students->flast.' '.$finantialRecord->students->slast) }}</td>
		                                <td class="text-center student_sex">{{ convertTitle($finantialRecord->students->sex) }}</td>
		                                <td class="text-center">{{ $finantialRecord->students->phone }}</td>
		                                <td class="text-center">{{ convertTitle($finantialRecord->students->address) }}</td>
		                                <td class="text-center">{{ convertTitle($finantialRecord->degreeDatos()->name) }}</td>
                                        <td class="text-center">{{ $finantialRecord->tuition_discount }}</td>
										<td class="text-center">{{ $finantialRecord->monthly_discount }}</td>
										<th class="text-center">{{ $finantialRecord->balance }}</th>
		                                <td class="text-center edit-row">
											<a href="{{route('editar-estudiante', $finantialRecord->students->token)}}"><i class="fa fa-pencil-square-o"></i></a>
		                                </td>
		                            </tr>
		                            @endif
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