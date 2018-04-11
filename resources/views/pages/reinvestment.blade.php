<input type="hidden" value="Withdraw" id="pageTitle" />
<input type="hidden" value="#reinvestimento" id="selectedTab" />

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

<script
	src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.4/inputmask/inputmask.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.4/inputmask/inputmask.numeric.extensions.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.4/inputmask/jquery.inputmask.js"></script>


<div style="width: 80%; margin: 0 auto;">
	<div class="panel panel-default">
		<div class="panel-heading">New reinvestment request:</div>
		<div class="panel-body">
			<form id="investmentForm" class="form-horizontal" action="reinvestment"
				role="form" data-toggle="validator" method="POST">
				<div class="form-group">
					<div class="col-sm-6">Create a reinvestment request bellow:</div>
					<div class="col-sm-4"></div>
					<div class="col-sm-6">
						<div id="message">
							<span style="color: red; font-size: 16px;"> @if( !
								empty($message)) {{ $message }} @endif </span>
						</div>
					</div>

				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="investimentValue">Value:</label>
					<div class="row">
						<div class="col-sm-4">
							<input name="investimentValue" type="text" class="form-control"
								id="investimentValue" placeholder="Enter value"
								value="<?php echo $balance;  ?>"
								required>
							

						</div>
						<label class="control-label col-sm-1" for="plan">Plan:</label>
						<div class="col-sm-2">
							<select name="plan" class="form-control">
								<?php 
								if (! empty($plans)) {
								    foreach ($plans as $plan) {
								?>
								<option value="<?php echo $plan->id?>">
									<?php echo $plan->name?>
								</option>
								<?php }
								    }?>
							</select>
						</div>
						<div class="help-block with-errors "></div>
					</div>
					
					<label class="control-label col-sm-3" for="email">Current account:</label>
					<div class="row">
						<div class="col-sm-4">

							<input id="currentBalance" name="currentBalance" type="text" class="form-control"
								value="<?php echo $balance;  ?>"
								style="color: green;" readonly="readonly">
						</div>
					</div>

				</div>
				<div >
					<button type="submit" class="btn btn-default pull-right"
						style="margin-right: 50px;">Request</button>
				</div>
			</form>
		</div>
	</div>


	



</div>


<script
	src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.js"></script>


<script type="text/javascript">

$(document).ready(function(){
    $("#investimentValue").inputmask('currency', {
                'alias': 'numeric',
                'groupSeparator': ',',
                'autoGroup': true,
                'digits': 0,
                'digitsOptional': false,
                'allowMinus': false,
                'placeholder': '',
                'removeMaskOnSubmit': true
    });
});



 $(document).ready(function(){
    $("#currentBalance").inputmask('currency', {
                'alias': 'numeric',
                'groupSeparator': ',',
                'autoGroup': true,
                'digits': 0,
                'digitsOptional': false,
                'allowMinus': false,
                'placeholder': ''
    });
}); 


 $('#investimentForm').validator();
 
</script>

@stop


