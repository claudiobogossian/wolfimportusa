<?php
use function Monolog\Handler\error_log;
?>
<input type="hidden" value="#painel" id="selectedTab" />
@extends('layouts.default') @section('content')

 		 <?php
    $request = request();
    
    $loggeduser = $request->session()->get('loggeduser');
    
    ?>
	<?php 
	$request = request();
	$currentcurrency = $request->session()->get('currentcurrency');
	//$investmentsList = $request->session()->get('investmentsList');
 ?>
<input type="hidden" value="Main Panel" id="pageTitle" />
<div class="col-sm-4">
	<div class="panel panel-default">
		<div class="panel-heading">Account Details</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6 control-label"
					style="font-weight: bold; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Geneva', 'Verdana', sans-serif;">
					Full Name</div>
				<div class="col-sm-2 control-label" style="font-weight: bold;">
					Status</div>
				<div class="col-sm-4 control-label" style="font-weight: bold;">
					Currency</div>
			</div>
			<div class="row">
				<div class="col-sm-6  control-label">
				<?php echo  $loggeduser->firstname." ".$loggeduser->lastname; ?> 
			</div>
				<div class="col-sm-2  control-label">Active</div>
				<div class="col-sm-4  control-label"><?php echo $currentcurrency->name." (".$currentcurrency->prefix.")"?></div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-8 control-label" style="font-weight: bold;">
					E-mail</div>

			</div>
			<div class="row">
				<div class="col-sm-8  control-label">
				<?php echo $loggeduser->email; ?> 
			</div>

			</div>
		</div>
	</div>
</div>
<div class="col-sm-8">
	<div class="panel panel-default">
						<script src="http://www.chartjs.org/dist/2.7.1/Chart.bundle.js"></script>
                    <script src="http://www.chartjs.org/samples/latest/utils.js"></script>
                    <script>

                    	var chartsOnLoadFunctions = new Array();
						
                    	
                    </script>
	<?php 
	$i = 1;
	if (! empty($investmentsList)) {
	    foreach ($investmentsList as $investment) {
	 ?>
	 
	 
	 <div class="panel-heading">Investing Details</div>
		<div class="panel-body">

			<div class="col-sm-4">
				<div class="row control-label" style="font-weight: bold;">Status</div>
				<div class="row control-label"><?php echo $investment['done']?"<p style='color: red'>Done</p>":"<p style='color: green'>Active</p>"?></div><br>
				<div class="row control-label" style="font-weight: bold;">Active
					Investiment</div>
				<div class="row control-label"><?php echo $currentcurrency->prefix." ".$investment['activeInvestimentValue']?></div><br>
				<div class="row control-label" style="font-weight: bold;">Daily
					Income</div>
				<div class="row control-label"><?php echo $currentcurrency->prefix." ".$investment['activeDailyIncome']?></div><br>
				<div class="row control-label" style="font-weight: bold;">
					Accumulated Income</div>
				<div class="row control-label"><?php echo $currentcurrency->prefix." ".$investment['accumulatedIncome']?></div><br>
				<div class="row control-label" style="font-weight: bold;">
					Approval Date</div>
				<div class="row control-label"><?php echo $investment['approvaldate']?></div><br>
				<div class="row control-label" style="font-weight: bold;">
					Due Date</div>
				<div class="row control-label"><?php echo $investment['duedate']?></div><br>
			

			</div>
			<div class="col-sm-8 control-label">
			
				<canvas id="canvas<?php echo $i?>"></canvas>
				

                    <script>
                    //var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                    var config<?php echo $i?> = {
                        type: 'line',
                        data: {
                            labels: [
                            	<?php 
                            	foreach($investment['chartData'] as $key => $value)
                               	{
                               	    if( next( $investment['chartData'] ) ) {
                               	        echo "'".$key."',";
                               	    }
                               	    else 
                               	    {
                               	        echo "'".$key."'";
                               	    }
                               	    
                            	}
                            	?>
                               ],
                            datasets: [{
                                label: "Daily Profit",
                                backgroundColor: window.chartColors.blue,
                                borderColor: window.chartColors.blue,
                                data: [
                                	<?php 
                                            foreach($investment['chartData'] as $key => $value)
                                           	{
                                           	    if( next( $investment['chartData'] ) ) {
                                           	        echo $value.",";
                                           	    }
                                           	    else 
                                           	    {
                                           	        echo $value;
                                           	    }
                                           	    
                                        	}
                                        	?>
                                ],
                                fill: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            title:{
                                display:true,
                                text:''
                            },
                            tooltips: {
                                mode: 'index',
                                intersect: false,
                            },
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Month'
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Value'
                                    }
                                }]
                            }
                        }
                    };
                    
                    chartsOnLoadFunctions.push(function() {
                        var ctx<?php echo $i?> = document.getElementById("canvas<?php echo $i?>").getContext("2d");
                        window.myLine<?php echo $i?> = new Chart(ctx<?php echo $i?>, config<?php echo $i?>);
                    });
                    
                    </script>
				
			</div>



		</div>
	 
	 
	 <?php 
	      $i++;  
	    }
	}
	
	else 
	{ 
	    //No Active Investiment
	    ?>
	    <div class="panel-heading">Investing Details</div>
		<div class="panel-body">
			<button type="button" class="btn btn-primary center-block" onclick="window.location='investiment-form'">Invest Right Now!!</button>
		</div>
		
	    
	    <?php 
	}
	
	?>
	<script>

	window.onload = function()
	{
		chartsOnLoadFunctions.forEach(function(chartFunction) {
			chartFunction();
		});
	}
	
	</script>
		
	</div>
</div>
<br>
<div class="col-sm-12">
	<div class="panel panel-default">
		<div class="panel-heading">Company Profits</div>
		<div class="panel-body"></div>
	</div>
</div>




@stop
