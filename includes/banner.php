<?php require_once "header.php"; ?>
<body>
	<header>
		<div class="alert alert-info text-center"><strong><i class="fa fa-exclamation-circle fa-lg"></i> &nbsp;This website and the ticketing service is currently undergoing testing. DO NOT USE IT YET!</strong></div>
		<!--- top menu starts here-->
		<nav class="navbar navbar-default" role="navigation">
			<div class="container">
			  <!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo BASE_URL; ?>">TravelHub</a>
					<!--<a class="navbar-brand" href="<?php /*echo BASE_URL; */?>"><img src="<?php /*echo BASE_URL; */?>images/travelhub-logo.gif" id="logo" /></a>-->
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav nav-links">
						<li><a href="#<?php echo BASE_URL; ?>smsticket.php">SMS Ticket</a></li>
						<li><a href="#<?php echo BASE_URL; ?>cancelTicket.php">Cancel Ticket</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<!-- top menu ends here -->
