<!DOCTYPE html>
<html lang="pt-BR" class="no-js">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<style>
#particles-js {
	height: 250px !important;
}

.header_img {
	padding-bottom: 0px !important;
}

.nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover
	{
	background-color: rgba(0, 0, 0, 0.4) !important;
}

.nav-pills>li>a:hover {
	background-color: rgba(0, 0, 0, 0.2) !important;
}

.nav-pills a {
	color: white;
}

.nav-pills a {
	padding: 0px !important;
}
</style>

<script>
	(function(html) {
		html.className = html.className.replace(/\bno-js\b/, 'js')
	})(document.documentElement);
</script>
<title>Wolf Imports</title>
<link rel="alternate" type="application/rss+xml"
	title="Feed de Wolf Imports &raquo;" href="feed/" />
<link rel="alternate" type="application/rss+xml"
	title="Wolf Imports &raquo;  Feed de comentários" href="comments/feed/" />
<link rel='stylesheet' id='animateMin-css' href='css/animate.min.css'
	type='text/css' media='all' />
<link rel='stylesheet' id='this-style-css' href='css/style.css'
	type='text/css' media='all' />
<link rel='stylesheet' id='sitemush-fonts-css'
	href='https://fonts.googleapis.com/css?family=Merriweather%3A400%2C700%2C900%2C400italic%2C700italic%2C900italic%7CMontserrat%3A400%2C700%7CInconsolata%3A400&#038;subset=latin%2Clatin-ext'
	type='text/css' media='all' />
<link rel='stylesheet' id='genericons-css' href='css/genericons.css'
	type='text/css' media='all' />
<link rel='stylesheet' id='sitemush-style-css' href='css/1-style.css'
	type='text/css' media='all' />
<!--[if lt IE 10]>
<link rel='stylesheet' id='sitemush-ie-css'  href='css/ie.css' type='text/css' media='all' />
<![endif]-->
<!--[if lt IE 9]>
<link rel='stylesheet' id='sitemush-ie8-css'  href='css/ie8.css' type='text/css' media='all' />
<![endif]-->
<!--[if lt IE 8]>
<link rel='stylesheet' id='sitemush-ie7-css'  href='css/ie7.css' type='text/css' media='all' />
<![endif]-->
<link rel='stylesheet' id='mpce-theme-css' href='css/theme.css'
	type='text/css' media='all' />
<style id='mpce-theme-inline-css' type='text/css'>
.sm-row-fixed-width {
	max-width: 1170px;
}
</style>
<link rel='stylesheet' id='mpce-bootstrap-grid-css'
	href='css/bootstrap-grid.min.css' type='text/css' media='all' />
<link rel='stylesheet' id='mpce-font-awesome-css'
	href='css/font-awesome.min.css' type='text/css' media='all' />

<!--[if lt IE 9]>
<script type='text/javascript' src='js/html5.js'></script>
<![endif]-->
<link rel='https://api.w.org/' href='szp-json/' />
<link rel="EditURI" type="application/rsd+xml" title="RSD"
	href="xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml"
	href="site-inc/wlwmanifest.xml" />
<meta name="generator" content="SitePad" />
<link rel="canonical" href="" />
<link rel='shortlink' href='' />


<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<script type='text/javascript' src='js/wow.min.js'></script>
<script type='text/javascript' src='js/main.js'></script>
<script type='text/javascript' src='js/particles.min.js'></script>

<style type="text/css">
.recentcomments a {
	display: inline !important;
	padding: 0 !important;
	margin: 0 !important;
}

body {
	font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Geneva', 'Verdana',
		sans-serif;
	font-size: 12px;
}
</style>
</head>

<body class="home page page-id-6 page-template-default">
	<div id="page" class="site container-fluid">

		<div class="site-inner">


			<header id="masthead" class="site-header" role="banner">
				<div data-stellar-background-ratio="0.5"
					class="sm-row-fluid smue-row smue-row-parallax sme-dsbl-margin-left sme-dsbl-margin-right animated_bg"
					style="background-image: url('images/banner.jpg'); height: 250px;">

					<div
						class="sm-span12 smue-clmn  sme-dsbl-margin-left sme-dsbl-margin-right header_img"
						style="height: 250px;">
						<div
							class="sm-row-fluid smue-row sme-dsbl-margin-left sme-dsbl-margin-right header_mid_row">
							<div
								class="sm-span12 smue-clmn sme-dsbl-margin-left sme-dsbl-margin-right">
								<div class="smue-text-obj wow fadeInUp delay_05s">
									<h3 style="text-align: center;">Wolf Imports USA</h3>
								</div>

							</div>
						</div>
					</div>

				</div>
			</header>



			<div
				style="width: 100%; background-color: #666664; position: absolute; margin-left: -15px; margin-right: -15px;"
				id="menu">
				<div class="container" style="">
    		 <?php
    $request = request();
    
    if ($request->session()->has('loggeduser')) {
        
        ?>
			<div class="col-sm-11">
						<ul class="nav nav-pills">
							<li id="painel" class="active"><a href="index.php"><img src="img/menu/painel.png"></a></li>
							<li id="saque"><a href="withdraw-form"><img src="img/menu/saque.png"></a></li>
							<li id="novoinvestimento"><a href="#"><img src="img/menu/novoinvestimento.png"></a></li>
							<li id="reinvestimento"><a href="#"><img src="img/menu/reinvestimento.png"></a></li>
							<li id="dadospagamento"><a href="#"><img src="img/menu/dadospagamento.png"></a></li>
							<li id="historico"><a href="#"><img src="img/menu/historico.png"></a></li>

						</ul>

					</div>
					<div class="btn-group" style="    padding-top: 10px; color: white;">
						<button type="button" class="glyphicon glyphicon-user"
							data-toggle="dropdown" aria-expanded="false" style="background-color: gray;">
							<span class="caret"></span> <span class="sr-only">T</span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Edit Profile</a></li>
							<li class="divider"></li>
							<li><a href="logout">Logout</a></li>
						</ul>
					</div>

					<script>
  $(function () {
    $('.dropdown-toggle').dropdown();
  }); 
</script>

              
              <?php } ?>
            </div>
			</div>
			<!-- .site-header -->



			<div id="content" class="site-content container"
				style="padding-top: 60px;">
				<div class="panel panel-default">
					<div class="panel-heading" id="pageTitleDiv"></div>
					<div class="panel-body">
						<div id="primary" class="content-area">
							<main id="main" class="site-main" role="main">

							<article id="post-6"
								class="post-6 page type-page status-publish hentry">

								<div class="entry-content">
									<div id="main" class="row">@yield('content')</div>
									<!-- .entry-content -->
							
							</article>
							<!-- #post-## --> </main>
							<!-- .site-main -->
						</div>

					</div>
				</div>
				<!-- .content-area -->


			</div>
			<!-- .site-content -->

		</div>
		<!-- .site-inner -->
	</div>
	<!-- .site -->

	<link rel='stylesheet' id='mpce-cda-style-css' href='css/style.min.css'
		type='text/css' media='all' />
	<link rel='stylesheet' id='mpce-cfa-style-css'
		href='css/1-style.min.css' type='text/css' media='all' />
	<script type='text/javascript' src='js/skip-link-focus-fix.js'></script>
	<script type='text/javascript'>
		/* <![CDATA[ */
		var screenReaderText = {
			"expand" : "expand child menu",
			"collapse" : "collapse child menu"
		};
		/* ]]> */
	</script>
	<script type='text/javascript' src='js/functions.js'></script>
	<script type='text/javascript' src='js/szp-embed.min.js'></script>
	<script type='text/javascript' src='js/jquery.stellar.min.js'></script>
	<script type='text/javascript' src='js/mp-row-parallax.js'></script>
	<script type='text/javascript' src='js/jquery.waypoints.min.js'></script>
	<script type='text/javascript' src='js/mp-waypoint-animations.js'></script>
	<script type='text/javascript' src='js/engine.min.js'></script>
	<script type='text/javascript' src='js/jquery.plugin_countdown.min.js'></script>
	<script type='text/javascript' src='js/jquery.countdown.min.js'></script>
	<script type='text/javascript' src='js/modernizr.min.js'></script>

	<style id="smue-ce-private-styles" data-posts="" type="text/css"></style>

	<script>

	if($('#pageTitle'))
	{
		
		$(document).ready(function() { 
		     $("#pageTitleDiv").html($('#pageTitle').val());
		});
	}

	if($('#selectedTab'))
	{
		
		$(document).ready(function() {
    
		     $("#painel").attr('class',"");
		     $("#saque").attr('class',"");
		     $("#novoinvestimento").attr('class',"");
		     $("#reinvestimento").attr('class',"");
		     $("#dadospagamento").attr('class',"");
		     $("#historico").attr('class',"");

			$($('#selectedTab').val()).attr('class',"active");
		});
	}

	</script>
</body>
</html>