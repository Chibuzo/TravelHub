<?php require_once "header.php"; ?>
<body>
	<header>
		<!--- top menu starts here-->
		<nav class="navbar navbar-default" role="navigation">
			<div class="container">
			  <!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="<?php echo BASE_URL; ?>"><img src="<?php echo BASE_URL; ?>images/logo.png" id="logo" /></a>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav nav-links">
						<li><a href="about.php">About</a></li>
						<li><a href="howitworks.php">How it works</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<!-- top menu ends here -->
