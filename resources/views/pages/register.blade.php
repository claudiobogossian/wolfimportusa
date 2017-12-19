@extends('layouts.default') @section('content')
<div style="width: 50%; margin: 0 auto;">
	<form class="form-horizontal" action="/action_page.php">
		<div class="form-group">
			<label class="control-label col-sm-4" for="email">Email:</label>
			<div class="col-sm-6">
				<input type="email" class="form-control" id="email"
					placeholder="Enter email">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="pwd">First name:</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" id="pwd"
					placeholder="Enter first name">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="pwd">Last name:</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" id="pwd"
					placeholder="Enter last name">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="pwd">Document:</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" id="pwd"
					placeholder="Enter document">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="pwd">Password:</label>
			<div class="col-sm-6">
				<input type="password" class="form-control" id="pwd"
					placeholder="Enter password">
			</div>
		</div>
		<div class="form-group">	
			<label class="control-label col-sm-4" for="pwd">Confirm password:</label>
			<div class="col-sm-6">
				<input type="password" class="form-control" id="pwd"
					placeholder="Enter document">
			</div>
		</div>
		<div class="col-sm-8">
			<button type="submit" class="btn btn-default pull-right" style="margin-right: 50px;">Register</button>
		</div>
	</form>


</div>
@stop
