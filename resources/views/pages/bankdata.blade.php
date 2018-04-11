<input type="hidden" value="Withdraw" id="pageTitle" />
<input type="hidden" value="#dadospagamento" id="selectedTab" />

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
		<div class="panel-heading">Bank Account Data:</div>
		<div class="panel-body">
			<form id="userForm" class="form-horizontal" action="updatebankdata"
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
			<label class="control-label col-sm-4" for="fullname">Full Name:</label>
			<div class="col-sm-6">
				<input name="fullname" type="text" class="form-control" id="fullname"
					placeholder="Enter name"
					value="<?php 
					
					if(empty($bankdata)) 
					{ 
					    echo $userdata->firstname." ".$userdata->lastname;
					}
					else
					{
					    echo $bankdata->fullname;
					}
					
					?>" required>
				<div class="help-block with-errors "></div>
			</div>

		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-4" for="document">Document:</label>
			<div class="col-sm-6">
				<input name="document" type="text" class="form-control"
					id="document" placeholder="Enter document"
					value="<?php
					
					if(empty($bankdata))
					{
					    echo $userdata->document;
					}
					else
					{
					    echo $bankdata->document;
					}
					
					
					  ?>"
					required>
				<div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="bankcode">Bank code:</label>
			<div class="col-sm-6">
				<input name="bankcode" type="text" class="form-control"
					id="bankcode" placeholder="Enter bank code"
					value="<?php if(!empty($bankdata)) { echo $bankdata->bankid; }  ?>"
					required>
				<div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="agency">Agency number:</label>
			<div class="col-sm-6">
				<input name="agency" type="text" class="form-control"
					id="agency" placeholder="Enter agency"
					value="<?php if(!empty($bankdata)) { echo $bankdata->agency; }  ?>"
					required>
				<div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="account">Account number:</label>
			<div class="col-sm-6">
					<input name="account" type='text' class="form-control"
						id="account"
						value="<?php if(!empty($bankdata)) { echo $bankdata->account; }  ?>" placeholder="Enter account number"
						required /> 
				<div class="help-block with-errors"></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-4" for="pwd">Account type:</label>
			<div class="col-sm-6">
			
				<select name="type" class="form-control" id="type"
					required>
					<option value=""></option>
					<option value="0" <?php 
					if(!empty($bankdata))
					{
					    if($bankdata->type==0)
					    {
					        echo "selected=\"selected\"";
					    }
					}
					    ?>>Checking Account</option>
					<option value="1" <?php 
					if(!empty($bankdata))
					{
					    if($bankdata->type==1)
					    {
					        echo "selected=\"selected\"";
					    }
					}
					    ?>>Savings Account</option>
					</select>
						<div class="help-block with-errors"></div>
			</div>
		</div>
		
		<div class="col-sm-8">
			<button type="submit" class="btn btn-default pull-right"
				style="margin-right: 50px;">Update</button>
		</div>
	</form>
		</div>
	</div>

</div>


<script
	src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.js"></script>


<script type="text/javascript">


 $('#investimentForm').validator();
 
</script>

@stop


