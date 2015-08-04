@extends('layouts.school')

@section('styles')
	<style>
		a:hover{
			text-decoration: none;
		}
	</style>
@endsection

@section('content')
	<div class="row paddingWrapper">
		@foreach($schools as $school)
	  	<div class="col-sm-6 col-md-4">
		    <div class="thumbnail paddingWrapper">
		    	<div class="text-center">
		      		<a class="routeSchool" href="#" data-token="{{$school->token}}" data-route="{{$school->route}}">
		      			<img src="{{ asset('images/logo-valle-de-angeles.jpg') }}" width="150">
		      		</a>
		    	</div>
		      	<div class="caption text-center">
			        <a class="routeSchool" href="#" data-token="{{$school->token}}" data-route="{{$school->route}}">
			        	<h4>{{convertTitle($school->name)}}</h4>
			        </a>
		      	</div>
		    </div>
		</div>
    	@endforeach
  	</div>

@endsection

@section('scripts')
	<script src="{{ asset('bower_components/blockUI/jquery.blockUI.js') }}"></script>
	<script src="{{ asset('bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('bower_components/matchHeight/jquery.matchHeight-min.js') }}"></script>
	<script src="{{ asset('bower_components/bootbox/bootbox.js') }}"></script>
	<script>
		$(".message .col-md-6:first").empty();
		$(".message .col-md-6:first").html('<a href="{{URL::to('/')}}"><img src="{{ asset('images/logo.png') }}" height="60px"></img></a>');
		$(".message .col-md-6").css('line-height', '4em');
		$('.thumbnail').matchHeight();
	</script>
@endsection