@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bower_components/datatables-bootstrap3-plugin/media/css/datatables-bootstrap3.css') }}">
@endsection

@section('page')
	<aside class="page"> 
		<h2>Notas</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Notas</a></li>
				<li class="active-page"><a>Ver Notas</a></li>
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
							<h5><strong>Lista de Notas</strong></h5>
						</div>
						<div class="col-sm-6">
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_note" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                                <th>Descripción</th>
	                                <th>Fecha</th>
	                                <th>Tipo</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($notes as $note) <?php echo json_encode($note->typeForms); die; ?>
		                            <tr>
		                                <td class="text-center">{{ convertTitle($note->description) }}</td>
		                                <td class="text-center">{{ $note->date }}</td>
		                                <td class="text-center"></td>
		                                <td class="text-center edit-row">
											<a href="{{route('editar-notas', $note->token)}}"><i class="fa fa-pencil-square-o"></i></a>
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