@extends('layouts.default') @section('content')

 		 <?php
    $request = request();
    
    $loggeduser = $request->session()->get('loggeduser');
    
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
				<div class="col-sm-3 control-label" style="font-weight: bold;">
					Status</div>
				<div class="col-sm-2 control-label" style="font-weight: bold;">
					Currency</div>
			</div>
			<div class="row">
				<div class="col-sm-6  control-label">
				<?php echo  $loggeduser->firstname." ".$loggeduser->lastname; ?> 
			</div>
				<div class="col-sm-3  control-label">Active</div>
				<div class="col-sm-2  control-label">TODO</div>
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
		<div class="panel-heading">Investing Details</div>
		<div class="panel-body">

			<div class="col-sm-4">
				<div class="row control-label" style="font-weight: bold;">Active
					Investiment</div>
				<div class="row control-label">TODO</div><br>
				<div class="row control-label" style="font-weight: bold;">Daily
					Income</div>
				<div class="row control-label">TODO</div><br>
				<div class="row control-label" style="font-weight: bold;">
					Accumulated Income</div>
				<div class="row control-label">TODO</div><br>

			</div>
			<div class="col-sm-8 control-label">
			
				<canvas id="canvas"></canvas>
			</div>



		</div>
	</div>
</div>
<br>
<div class="col-sm-12">
	<div class="panel panel-default">
		<div class="panel-heading">Company Profits</div>
		<div class="panel-body"></div>
	</div>
</div>

<script src="http://www.chartjs.org/dist/2.7.1/Chart.bundle.js"></script>
<script src="http://www.chartjs.org/samples/latest/utils.js"></script>
<script>
//var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var config = {
    type: 'line',
    data: {
        labels: ["20/11", "21/11", "22/11", "23/11", "24/11", "25/11"],
        datasets: [{
            label: "Daily Profit",
            backgroundColor: window.chartColors.blue,
            borderColor: window.chartColors.blue,
            data: [
                100,
                110,
                115,
                130,
                125,
                160
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
window.onload = function() {
    var ctx = document.getElementById("canvas").getContext("2d");
    window.myLine = new Chart(ctx, config);
};
</script>


@stop
