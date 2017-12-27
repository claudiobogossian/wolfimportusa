<input type="hidden" value="Withdraw" id="pageTitle" />
<input type="hidden" value="#novoinvestimento" id="selectedTab" />

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
		<div class="panel-heading">New investiment request:</div>
		<div class="panel-body">
			<form id="investimentForm" class="form-horizontal" action="investiment"
				role="form" data-toggle="validator" method="POST">
				<div class="form-group">
					<div class="col-sm-6">Create a investiment request bellow:</div>
					<div class="col-sm-4"></div>
					<div class="col-sm-6">
						<div id="message">
							<span style="color: red; font-size: 16px;"> @if( !
								empty($message)) {{ $message }} @endif </span>
						</div>
					</div>

				</div>
				<div class="form-group">
					<label class="control-label col-sm-4" for="investimentValue">Value:</label>
					<div class="row">
						<div class="col-sm-4">
							<input name="investimentValue" type="text" class="form-control"
								id="investimentValue" placeholder="Enter value"
								value="0"
								required>
							<div class="help-block with-errors "></div>

						</div>
					</div>
					
					<!-- label class="control-label col-sm-4" for="email">Current account:</label>
					<div class="row">
						<div class="col-sm-2">

							<input id="currentBalance" name="currentBalance" type="text" class="form-control"
								value="<?php //echo $balance;  ?>"
								style="color: green;" readonly="readonly">
						</div>
					</div -->

				</div>
				<div >
					<button type="submit" class="btn btn-default pull-right"
						style="margin-right: 50px;">Request</button>
				</div>
			</form>
		</div>
	</div>


	<div class="panel panel-default">
		<div class="panel-heading">Investiment Request History:</div>
		<div class="panel-body">

			<div class="container" style="width: 100%;">
				<table class="table table-bordered table-striped">
					<tr>
						<th>ID</th>
						<th>Value</th>
						<th>Status</th>
						<th>Date</th>
						<th>Plan</th>
					</tr>
					<?php
    
    if (! empty($investiments)) {
        foreach ($investiments as $investiment) {
            ?>
					 <tr>
						<td><?php echo $investiment->id ?></td>
						<td><?php echo $investiment->value ?></td>
						<td><?php echo $investiment->name ?></td>
						<td><?php echo $investiment->date ?></td>
						<td><?php echo $investiment->planname ?></td>
					</tr>
					        <?php
        }
    }
    
    ?>
					
				</table>
			</div>

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

/* $(document).ready(function(){
    $("#currentBalance").inputmask('currency', {
                'alias': 'numeric',
                'groupSeparator': ',',
                'autoGroup': true,
                'digits': 0,
                'digitsOptional': false,
                'allowMinus': false,
                'placeholder': ''
    });
}); */


 $('#investimentForm').validator();
 
</script>

@stop

