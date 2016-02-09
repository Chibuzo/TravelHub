<?php require_once "header.php"; ?>
<body>
	<header>
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
					<a class="navbar-brand" href="">TravelHub</a>
					<!--<a class="navbar-brand" href="<?php /*echo BASE_URL; */?>"><img src="<?php /*echo BASE_URL; */?>images/logo.png" id="logo" /></a>-->
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav nav-links">
						<li><a href="<?php echo BASE_URL; ?>smsticket.php">SMS Ticket</a></li>
						<li><a href="#<?php echo BASE_URL; ?>cancelTicket.php">Cancel Ticket</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<!-- top menu ends here -->
