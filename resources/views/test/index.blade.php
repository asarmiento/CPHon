<form class="form-horizontal" role="form" method="POST" action="/test" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<input type="file" name="file" value="" placeholder="">
	<input class="btn btn-default" type="submit" value="Submit">
</form>