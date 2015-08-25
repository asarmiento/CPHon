@extends('layouts.app')

@section('page')
	<aside class="page"> 
		<h2>{{ $page }}</h2>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<div class="form-group has-error">
	        <h3 class="control-label bg-danger" style="padding: 1em;">{{ $error }}</h3>
	    </div>
		{{-- <div class="row text-center">
			<button class="btn btn-default" onclick="history.go(-1);"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
		</div> --}}
	</div>
@endsection