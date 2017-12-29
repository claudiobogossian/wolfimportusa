<input type="hidden" value="History" id="pageTitle" />
<input type="hidden" value="#historico" id="selectedTab" />

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
		<div class="panel-heading">User Request History:</div>
		<div class="panel-body">

			<div class="container" style="width: 100%;">
				<table class="table table-bordered table-striped">
					<tr>
						<th>ID</th>
						<th>Date</th>
						<th>Type</th>
						<th>Status</th>
					</tr>
					<?php
    if (! empty($usersrequest)) {
        foreach ($usersrequest as $ur) {
            ?>
					 <tr>
						<td><?php echo $ur->id ?></td>
						<td><?php echo $ur->date ?></td>
						<td><?php echo $ur->requesttypename ?></td>
						<td><?php echo $ur->requeststatusname ?></td>
					</tr>
					        <?php
        }
    }    else
    {
        ?>
        <tr>
        	<td colspan="5" align="center">No user requests</td>
        </tr>
        
        <?php 
    }
    
    ?>
					
				</table>
			</div>

		</div>
	</div>


	<div class="panel panel-default">
		<div class="panel-heading">Investment Request History:</div>
		<div class="panel-body">

			<div class="container" style="width: 100%;">
				<table class="table table-bordered table-striped">
					<tr>
						<th>ID</th>
						<th>Date</th>
						<th>Type</th>
						<th>Status</th>
						<th>Value</th>
					</tr>
					<?php
    
    if (! empty($investimentsrequest)) {
        foreach ($investimentsrequest as $ir) {
            ?>
					 <tr>
						<td><?php echo $ir->id ?></td>
						<td><?php echo $ir->date ?></td>
						<td><?php echo $ir->requesttypename ?></td>
						<td><?php echo $ir->requeststatusname ?></td>
						<td><?php echo $ir->value ?></td>
					</tr>
					        <?php
        }
    }
    else 
    {
        ?>
        <tr>
        	<td colspan="5"  align="center">No investments requests</td>
        </tr>
        
        <?php 
    }
    
    ?>
					
				</table>
			</div>

		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">Withdraw Request History:</div>
		<div class="panel-body">

			<div class="container" style="width: 100%;">
				<table class="table table-bordered table-striped">
					<tr>
						<th>ID</th>
						<th>Date</th>
						<th>Type</th>
						<th>Status</th>
						<th>Value</th>
					</tr>
					<?php
    
    if (! empty($withdrawsrequest)) {
        foreach ($withdrawsrequest as $wr) {
            ?>
					 <tr>
						<td><?php echo $wr->id ?></td>
						<td><?php echo $wr->date ?></td>
						<td><?php echo $wr->requesttypename ?></td>
						<td><?php echo $wr->requeststatusname ?></td>
						<td><?php echo $wr->value ?></td>
					</tr>
					        <?php
        }
    }
    else
    {
        ?>
        <tr>
        	<td colspan="5"  align="center">No withdraw requests</td>
        </tr>
        
        <?php 
    }
    
    ?>
					
				</table>
			</div>

		</div>
	</div>




</div>


@stop


