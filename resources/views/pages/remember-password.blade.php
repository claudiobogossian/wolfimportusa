<input type="hidden" value="Remember my password" id="pageTitle" />

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
    
    <form id="userForm" class="form-horizontal" action="forgetPassword"
		role="form" data-toggle="validator" method="POST">
	
		<div class="form-group">
				<div class="col-sm-4"></div>
				<div class="col-sm-6">
					<div id="message">
						<span style="color: red; font-size: 16px;"> @if( !
							empty($message)) {{ $message }} @endif </span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-1" for="email">Email:</label>
    			<div class="row">
    
    				<div class="col-sm-6">
    					<input name="email" type="email" class="form-control" id="email"
    						placeholder="Enter email"
    						value="<?php if(!empty($userdata)) { echo $userdata->email; }  ?>"
    						required>
    					<div class="help-block with-errors "></div>
    				</div>
    				<div class="col-sm-4 " style="padding-left:0px">
    					<button type="submit" class="btn btn-default pull-left" style="">
    						Send my password</button>
    				</div>
    
    
    			</div>

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
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.js"></script>





@stop
