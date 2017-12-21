<input type="hidden" value="User Registration" id="pageTitle" />

<style>
.help-block>ul>li {
	font-size: 12px;
}

.help-block {
	margin-top: 0px !important;
	margin-bottom: 0px !important;
}
</style>

@extends('layouts.default') @section('content')
<div style="width: 50%; margin: 0 auto;">
	<form id="userForm" class="form-horizontal" action="register"
		role="form" data-toggle="validator" method="POST">
		<div class="form-group">
			<div class="col-sm-4">
			</div>
			<div class="col-sm-6">
				<div id="message">
					<span style="color: red; font-size: 16px;"> @if( ! empty($message))
						{{ $message }} @endif </span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="email">Email:</label>
			<div class="col-sm-6">
				<input name="email" type="email" class="form-control" id="email"
					placeholder="Enter email"
					value="<?php if($userdata) { echo $userdata->email; }  ?>" required>
				<div class="help-block with-errors "></div>
			</div>

		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="pwd">First name:</label>
			<div class="col-sm-6">
				<input name="firstName" type="text" class="form-control"
					id="firstName" placeholder="Enter first name"
					value="<?php if($userdata) { echo $userdata->firstname; }  ?>"
					required>
				<div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="pwd">Last name:</label>
			<div class="col-sm-6">
				<input name="lastName" type="text" class="form-control"
					id="lastName" placeholder="Enter last name"
					value="<?php if($userdata) { echo $userdata->lastname; }  ?>"
					required>
				<div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="pwd">Birth date:</label>
			<div class="col-sm-6">
				<div class='input-group date' id='datetimepicker'>
					<input name="birthdate" type='text' class="form-control"
						id="birthdate"
						value="<?php if($userdata) { echo $userdata->birthdate; }  ?>"
						required /> <span class="input-group-addon"> <span
						class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
				<div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="pwd">Document:</label>
			<div class="col-sm-6">
				<input name="document" type="text" class="form-control"
					id="document" placeholder="Enter document"
					value="<?php if($userdata) { echo $userdata->document; }  ?>"
					required>
				<div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="pwd">Password:</label>
			<div class="col-sm-6">
				<input name="password" type="password" class="form-control" id="pwd"
					placeholder="Enter password"
					value="<?php if($userdata) { echo $userdata->password; }  ?>"
					required>
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
			<button type="submit" class="btn btn-default pull-right"
				style="margin-right: 50px;">Register</button>
		</div>
	</form>


</div>


<script type="text/javascript">
$(document).ready(function() {
        $(function () {
        	$(function () {
        	    $('#datetimepicker').datetimepicker({ format: 'DD/MM/YYYY' });
        	});
        });
    });
</script>

<script
	src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script type="javascript">

$('#form').validator().on('submit', function (e) {
  if (e.isDefaultPrevented()) {
    alert('wrong fields');
  } else {
    alert('all right'); 
  }
});



 
</script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.js"></script>





@stop
