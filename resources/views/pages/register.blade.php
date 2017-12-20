<input type="hidden" value="User Registration" id="pageTitle"/>

<style>

.help-block>ul>li
{
    font-size: 12px;
}
.help-block
 {
    margin-top: 0px !important;
    margin-bottom: 0px !important;
}
</style>

@extends('layouts.default') @section('content')
<div style="width: 50%; margin: 0 auto;">
	<form id="userForm" class="form-horizontal" action="register" role="form" data-toggle="validator" method="POST">
		<div class="form-group">
			<label class="control-label col-sm-4" for="email">Email:</label>
			<div class="col-sm-6">
				<input name="email" type="email" class="form-control" id="email"
					placeholder="Enter email" required>
				<div class="help-block with-errors " ></div>	
			</div>
			
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="pwd">First name:</label>
			<div class="col-sm-6">
				<input name="firstName" type="text" class="form-control" id="firstName"
					placeholder="Enter first name" required>
					<div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="pwd">Last name:</label>
			<div class="col-sm-6">
				<input name="lastName" type="text" class="form-control" id="lastName"
					placeholder="Enter last name" required>
					<div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="pwd">Document:</label>
			<div class="col-sm-6">
				<input name="documentName" type="text" class="form-control" id="document"
					placeholder="Enter document" required>
					<div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="pwd">Password:</label>
			<div class="col-sm-6">
				<input name="password" type="password" class="form-control" id="pwd"
					placeholder="Enter password" required>
					<div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="form-group">	
			<label class="control-label col-sm-4" for="pwd">Confirm password:</label>
			<div class="col-sm-6">
				<input type="password" class="form-control" id="pwdConfirm"
					placeholder="Repeat password" data-match="#pwd" required>
					<div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="col-sm-8">
			<button type="submit" class="btn btn-default pull-right" style="margin-right: 50px;">Register</button>
		</div>
	</form>


</div>
<script type="javascript">

$('#form').validator().on('submit', function (e) {
  if (e.isDefaultPrevented()) {
    alert('wrong fields');
  } else {
    alert('all right'); 
  }
});
 
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.js"></script>




@stop
