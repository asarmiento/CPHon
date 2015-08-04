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
				<li class="active-page"><a>Ver Estudiantes</a></li>
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
							<h5><strong>Lista de Estudiantes</strong></h5>		
						</div>
						<div class="col-sm-6">
							<a id="saveEnrolled" data-url="estudiantes" href="#" class="btn btn-success pull-left">
								<span class="fa fa-floppy-o"></span>
								<span>Generar Matrícula</span>
							</a>
							<a href="{{route('crear-estudiante')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_student" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
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
                                    <th>Estado Cuenta</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        @if( count($students) > 0 )
	                        	@foreach($students as $student)
		                            <tr>
		                                <td class="text-center student_name">{{ convertTitle($student->fname.' '.$student->sname) }}</td>
		                                <td class="text-center student_last">{{ convertTitle($student->flast.' '.$student->slast) }}</td>
		                                <td class="text-center student_sex">{{ convertTitle($student->sex) }}</td>
		                                <td class="text-center">{{ $student->phone }}</td>
		                                <td class="text-center">{{ convertTitle($student->address) }}</td>
		                                <td class="text-center">{{ convertTitle($student->degreeDatos()->name) }}</td>
                                        <td class="text-center">{{ $student->financialRecords->tuition_discount }}</td>

										<td class="text-center">{{ $student->financialRecords->monthly_discount }}</td>
										@if(strtolower($student->financialRecords->status) == 'no aplicado')
											<th class="text-center">Sin matrícula</th>
										@else
											<th class="text-center">{{ $student->financialRecords->balance }}</th>
										@endif

                                        <td class="text-center edit-row">
                                            <a target="_blank" href="{{route('ver-estado-de-cuenta-auxiliar', $student->token)}}"><i class="fa fa-file-excel-o"></i></a>
                                        </td>
		                                <td class="text-center edit-row">
											<a href="{{route('editar-estudiante', $student->token)}}"><i class="fa fa-pencil-square-o"></i></a>
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