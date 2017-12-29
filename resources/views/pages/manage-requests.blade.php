<input type="hidden" value="Manage Requests" id="pageTitle" />


<style>
.help-block>ul>li {
	font-size: 12px;
}

.help-block {
	margin-top: 0px !important;
	margin-bottom: 0px !important;
}

td
{
    vertical-align: middle !important;
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
		<div class="panel-heading">User Request:</div>
		<div class="panel-body">

			<div class="container" style="width: 100%;">
				<table class="table table-bordered table-striped">
					<tr>
						<th>ID</th>
						<th>E-Mail</th>
						<th>Date</th>
						<th>Status</th>
						<th>Percent</th>
						<th>Action</th>
					</tr>
					<?php
    if (! empty($usersrequest)) {
        foreach ($usersrequest as $ur) {
            ?>
            		<form action="updaterequest" method="post">
					
					
					<tr>
						<td><?php echo $ur->id ?></td>
						<td><?php echo $ur->email ?></td>
						<td><?php echo $ur->date ?></td>
						<td><select class="form-control" name="requeststatusid">
							<?php
            if (! empty($requeststatus)) {
                foreach ($requeststatus as $rs) {
                    ?>
							        	<option value="<?php echo $rs->id?>"
									<?php
                    if ($rs->id == $ur->requeststatusid) {
                        echo "selected=\"selected\"";
                    }
                    ?>><?php echo $rs->name?></option>
							        <?php
                }
            }
            
            ?>
							
						</select></td>
						<td><input class="form-control investimenttext" type="text" name="investmentpercent"
							value="<?php echo $ur->investimentpercent ?>"></td>
						<td  align="center">
							<input type="hidden" name="requestid" value="<?php echo $ur->id?>">
							<input type="hidden" name="requesttypeid" value="<?php echo $ur->requesttypeid?>">
							<button type="submit" class="btn btn-default"
								>Save</button>

						</td>
					</tr>
					</form>
					        <?php
        }
    } else {
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
		<div class="panel-heading">Investment Request:</div>
		<div class="panel-body">

			<div class="container" style="width: 100%;">
				<table class="table table-bordered table-striped">
					<tr>
						<th>ID</th>
						<th>Date</th>
						<th>Status</th>
						<th>Value</th>
						<th>Action</th>
					</tr>
					<?php
    
    if (! empty($investimentsrequest)) {
        foreach ($investimentsrequest as $ir) {
            ?>
            <form action="updaterequest" method="post">
					
					
					<tr>
						<td><?php echo $ir->id ?></td>
						<td><?php echo $ir->date ?></td>
						<td><select class="form-control" name="requeststatusid">
							<?php
            if (! empty($requeststatus)) {
                foreach ($requeststatus as $rs) {
                    ?>
							        	<option value="<?php echo $rs->id?>"
									<?php
                    if ($rs->id == $ir->requeststatusid) {
                        echo "selected=\"selected\"";
                    }
                    ?>><?php echo $rs->name?></option>
							        <?php
                }
            }
            
            ?>
							
						</select></td>
						<td><?php echo $ir->value ?></td>
						<td  align="center">
							<input type="hidden" name="requestid" value="<?php echo $ir->id?>">
							<input type="hidden" name="requesttypeid" value="<?php echo $ir->requesttypeid?>">
							<button type="submit" class="btn btn-default"
								>Save</button>

						</td>
					</tr>
					</form>
					        <?php
        }
    } else {
        ?>
        <tr>
						<td colspan="5" align="center">No investments requests</td>
					</tr>
        
        <?php
    }
    
    ?>
					
				</table>
			</div>

		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">Withdraw Request:</div>
		<div class="panel-body">

			<div class="container" style="width: 100%;">
				<table class="table table-bordered table-striped">
					<tr>
						<th>ID</th>
						<th>Date</th>
						<th>Status</th>
						<th>Value</th>
						<th>Action</th>
					</tr>
					<?php
    
    if (! empty($withdrawsrequest)) {
        foreach ($withdrawsrequest as $wr) {
            ?><form action="updaterequest" method="post">
					
					
					<tr>
						<td><?php echo $wr->id ?></td>
						<td><?php echo $wr->date ?></td>
						<td><select class="form-control" name="requeststatusid">
							<?php
            if (! empty($requeststatus)) {
                foreach ($requeststatus as $rs) {
                    ?>
							        	<option value="<?php echo $rs->id?>"
									<?php
                    if ($rs->id == $wr->requeststatusid) {
                        echo "selected=\"selected\"";
                    }
                    ?>><?php echo $rs->name?></option>
							        <?php
                }
            }
            
            ?>
							
						</select></td>
						<td>
						<?php echo $wr->value ?>
						</td>
						<td align="center">
						<input type="hidden" name="requesttypeid" value="<?php echo $wr->requesttypeid?>">
							<input type="hidden" name="requestid" value="<?php echo $wr->id?>">
							<button type="submit" class="btn btn-default"
								>Save</button>

						</td>
					</tr>
					</form>
					        <?php
        }
    } else {
        ?>
        <tr>
						<td colspan="5" align="center">No withdraw requests</td>
					</tr>
        
        <?php
    }
    
    ?>
					
				</table>
			</div>

		</div>
	</div>




</div>

<script type="text/javascript">

$(document).ready(function(){
    $(".investimenttext").inputmask("decimal", {
        radixPoint: ".",
        groupSeparator: ",",
        autoGroup: true,
        suffix: " %",
        clearMaskOnLostFocus: false,
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


