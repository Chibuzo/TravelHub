<?php
require_once "includes/banner.php";
require_once "includes/db_handle.php";


// submit bus charter
if (isset($_POST['bus_charter'])) {
	require_once "classes/buscharter.class.php";
	$buscharter = new BusCharter();
	extract($_POST);
	if ($buscharter->addBusCharter($name, $phone, $traveldate, $departure_location, $destination, $vehicle_type, $num_of_vehicles) === true) {
		$msg = true;
	}
}
?>

<style>
body { background-image:url('../images/bg.png'); background-repeat: repeat;}

header { box-shadow: 2px 0px 6px 2px #cc0000; }

#bus_search {
	float: left;
	width: 50%;
	padding: 10px;
}

h1 { font-size: 40px; color: #ccc; }

label { color: #fff; font-weight: normal; }

.feature { font-size: 17px; color: #bbb; font-weight: 100; }

.white-bg .col-md-4 .inner, .services {
	margin: 8px;
	padding: 8px 25px;
	padding-top: 20px;
	font-size: 17px;
	font-weight: 100;
	color: #666;
	text-align:center;
	background: rgba(255, 255, 255, 0.8);
	box-shadow: 0px 0px 5px 1px #ccc;
}

.services { padding-bottom: 30px; }

.services a { display: none; }

#bg {
  min-height: 100%;
  min-width: 1024px;

  /* Set up proportionate scaling */
  width: 100%;
  height: auto;

  /* Set up positioning */
  position: fixed;
  top: 0;
  left: 0;
}

#book-pane {
	background: rgb(255, 255, 255) transparent;
	background: rgba(0, 0, 0, 0.5);
	position: relative;
	top: -350px;
	z-index: 100;
	width: 42%;
	padding: 20px 60px;
	margin-left: 60px;
	min-height: 320px;
	border-radius: 5px;
}

#services { margin-top: -280px; }

.inner h2, .services h2 { color: #e43725; }

label { color: #999; }

#profile label { display: none; }

.tab-content { padding-top: 20px; }

.tab { list-style-type: none; margin-left: -39px; border-bottom: #666 solid thin; height:38px !important; }

.tab li { float: left; margin-bottom: 17px; padding: 8px 19px; }

.tab li:hover { background: rgba(0, 0, 0, 0.2); }

.tab li a:hover { text-decoration: none !important; }

.tab li a { color: #ccc !important; font: 300 17px 'Open Sans' !important; padding: 4px 8px; }

.tab li.active { background: rgba(0, 0, 0, 0.6); border: #666 solid thin; border-bottom: none; font-weight: 300; padding: 7px 18px; }

.tab li.active a:focus { text-decoration: none; }

@media screen and (min-width: 200px) and (max-width: 600px) {
	#book-pane {
		width: auto;
		margin: auto !important;
		top: 0px !important;
		padding: 5px;
		background: rgb(255, 255, 255) transparent;
		background: rgba(0, 0, 0, 0.8);
	}

	#book-ticket label {display: none; }

	#bus_charter { margin-top: 10px !important; }

	.slider-wrapper { display: none;}

	#services { margin-top: 30px; }
}

/* TABLETS PORTRAIT */
@media screen and (min-width: 600px) and (max-width: 768px) {
	#book-pane {
		width: auto;
		margin: auto !important;
		top: 0px !important;
		padding: 5px;
		background: rgb(255, 255, 255) transparent;
		background: rgba(0, 0, 0, 0.8);
	}

	.slider-wrapper { display: none;}

	#services { margin-top: 30px; }
}


/* TABLET LANDSCAPE / DESKTOP */
@media only screen and (min-width: 1024px) {


}

/* SLIDER STYLES */

.slider-wrapper{
	position:relative;
	overflow:hidden;

	width:100%;

	margin: auto;

	background: rgb(255, 255, 255) transparent;
	background: rgba(0, 0, 0, 0.8);
	background-image: url('images/road.jpg');
	-webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;

	border:1px solid #000;
	box-shadow:0 3px 5px #666;
}

.slider{
	position:relative;
	width:100%;
	height:400px; when responsive, comment this out
	margin:0 auto;

	/*background:#1b1b1b;*/
}

@media only screen and (min-width: 1000px){
	.slider{
		/*width:1000px;*/
	}
}

@media only screen and (min-width: 1440px){
	.slider{
		width:1440px;
	}
}

/* ELEMENT STYLES */

p{
	position:absolute;
	top:-200px;

	z-index:8000;
	padding:1% 3%;

	font-size:24px;
	line-height:100%
	color:#fff;
	white-space: nowrap;
	text-transform:uppercase;
}

.claim{
	line-height:100%
	/*padding: 3px 6px;*/
}

.teaser{
	padding:6px 10px;
	font-size:14px;
	 line-height:100%
}

.small{
	width:250px;
   padding-left:0; padding-right:0px;
	text-align:center;
}

.grey { background: rgb(255, 255, 255) transparent; background: rgba(0, 0, 0, 0.6); color: #ddd}

.light-green{background:#95C542;}
.green{background:#7CB761}
.orange{background:#EF7D00}
.red {background:#cc0000;}
.turky{background:#348E8A}
.white{background:#fff; color:#333}


.feature-wrap i{
  font-size: 48px;
  margin: auto !important;
  margin-top: 20px !important;
  text-align:center;
  background: none;
  color: #ccc;
}
</style>
<link href="css/datepicker.css" rel="stylesheet" />
<link href="css/datepicker3.css" rel="stylesheet" />
<link rel="stylesheet" href="css/fractionslider.css">
<link href="css/jquery.bxslider.css" rel="stylesheet" />
<script src="js/jquery.fractionslider.min.js" type="text/javascript" charset="utf-8"></script>
<!--<img src="images/bg.png" id="bg" alt="">-->
<div class="containerfluid">
	<div class="slider-wrapper">
		<div class="responisve-container container">
			<div class="slider">
				<div class="fs_loader"></div>
				<div class="slide">
					<img 	src="images/minibus1.png"
							width="595" height="291"
							data-position="60,580" data-in="left" data-delay="200" data-out="left">

					<!--<p 		class="claim grey"
							data-position="130,650" data-in="top" data-step="1" data-out="top" data-ease-in="easeOutBounce">Toyota Mini buses</p>

					<p 		class="teaser grey"
							data-position="180,650" data-in="left" data-out="right" data-step="2" data-delay="500">Comfortable 10 seater</p>-->

				</div>
				<div class="slide" datain="slideLeft">
					<img 	src="images/sienna.png"
							data-position="50,580" data-in="bottomRight" data-delay="0" data-out="right" stlye='left: 200px !important'>

					<!--<p 		class="claim grey"
							data-position="130,650" data-in="top" data-step="1" data-out="top">Sienna Buses</p>

					<p 		class="teaser grey"
							data-position="180,650" data-in="bottom" data-step="2" data-delay="500">Executive</p>
					<p 		class="teaser grey"
							data-position="210,650" data-in="bottom" data-step="2" data-delay="1500">Regular</p>
					<p 		class="teaser grey"
							data-position="240,650" data-in="bottom" data-step="2" data-delay="2500">Air conditioned</p>-->
				</div>
				<div class="slide">
					<img 	src="images/car1.png"
							width="595" height="291"
							data-position="60,580" data-in="bottom" data-delay="200" data-out="right">

					<!--<p 		class="claim grey"
							data-position="150,650" data-in="top" data-step="1" data-out="top">Toyota Saloon cars</p>

					<p 		class="teaser grey"
							data-position="200,650" data-in="bottom" data-out="right" data-step="2" data-delay="300">One in the front, two at the back</p>-->

				</div>
			</div>
		</div>
	</div>


			<div id="book-pane">
				<?php if (isset($msg)): ?>
				<div class="alert alert-info">Thank you customer, we have received your bus hire request, we'll contact you shortly.</div>
				<?php endif ?>
				<div role="tabpanel">
					<!-- Nav tabs -->
					<ul class="tab">
						<li role="presentation" class="active"><a href="#book-ticket" aria-controls="book-ticket" role="tab" data-toggle="tab">Book a Trip</a></li>
						<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Hire Bus</a></li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="book-ticket">
							<?php echo isset($_GET['msg']) ? "<div class='alert alert-error'>You must select travel destination to continue.</div>" : ''; ?>
							<form action="pick_bus.php" method="post" role="form">
								<div class="row" style="clear: both !important">
									<div class='col-md-6 clearfix'>
										<div class="form-group">
											<label for="origin">From</label>
											<select id="origin" name="origin" class="form-control">
												<option value="">-- Pick travel origin --</option>
												<option value="Lagos">Lagos</option>
												<option value="Enugu">Enugu</option>
												<option value="PortHarcourt">Port Harcout</option>
												<option value="Abuja">Abuja</option>
												<option value="Delta">Delta</option>
											</select>
										</div>
									</div>

									<div class='col-md-6'>
										<div class="form-group">
											<label for="destination">To</label>
											<select name="destination" id="destination" class="form-control">
												<option value="">-- Pick destination --</option>
											</select>
											<class id='error'></class>
										</div>
									</div>
								</div>

								<div class="row">
									<div class='col-md-6'>
										<div class="form-group">
											<label for="travel_date">Date of travel</label>
											<select name="travel_date" class="form-control">
											<?php
												for ($i = 1; $i < 30; $i++) {
													$date = mktime(0, 0, 0, date("m")  , date("d") + $i, date("Y"));
													echo "\t<option value=\"" . date('Y-m-d', $date) . "\">" . date('D, d M Y', $date) . "</option>\n";
												}
											?>
											</select>
										</div>
									</div>
									<div class='col-md-6'>
										<div class="form-group">
											<label>&nbsp;</label>
											<button type="submit" name="search" type="submit" class="btn btn-danger btn-block btn-submit"><span class="glyphicon glyphicon-search"></span> Find bus</button>
										</div>
									</div>
								</div>
							</form>
						</div>

						<div role="tabpanel" class="tab-pane" id="profile">
							<form action="" method="post" role="form">
								<div class="row" style="clear: both !important">
									<div class="col-md-6">
										<div class="form-group">
											<label for="travel_date">Your name</label>
											<input type="text" name="name" id="customer_name" class="form-control" placeholder="Your name" />
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="travel_date">Contact number</label>
											<input type="text" name="phone" id="customer_number" class="form-control" placeholder="Contact number" />
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="travel_date">Pick location</label>
											<input type="text" name="departure_location" class="form-control" placeholder="Pickup location" />
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="travel_date">Destination</label>
											<input type="text" name="destination" class="form-control" placeholder="Destination" />
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="travel_date">Vehicle type</label>
											<select name="vehicle_type" class="form-control">
												<option value="">-- Vehicle types --</option>
												<?php
													foreach ($db->query("SELECT * FROM bus_types") AS $bus) {
														echo "<option value='{$bus['id']}'>{$bus['name']} ({$bus['num_of_seats']} Seats)</opition>";
													}
												?>
											</select>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="travel_date">No of Vehicles</label>
											<input type="text" name="num_of_vehicles" class="form-control" placeholder="Number of Vehicles" />
										</div>
									</div>
								</div>


								<div class="row">
									<div class="col-md-6">
										<label for="travel_date">Date of travel</label>
										<div class="input-group">
											<input type="text" name="traveldate" class="form-control date" placeholder="Travel date" />
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>&nbsp;</label>
											<input type="submit" class="btn btn-danger btn-block" name="bus_charter" id="bus_charter" class="form-control" value="Submit request" />
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

</div>

<div class="container" id="services">
	<div class="row white-bg">
		<div class="col-md-4">
			<div class="inner">
				<h2>Steps to Book</h2>
				<div class="feature-wrap">
                    <i class="fa fa-taxi"></i>
				</div>
				<ul class="bxslider">
					<li><h3>Step 1</h3>Pick your route and travel date</li>
					<li><h3>Step 2</h3>Click "Find bus"</li>
					<li><h3>Step 3</h3>Click a vehicle of your choice</li>
					<li><h3>Step 4</h3>Pick a seat of your choice</li>
				</ul>
			</div>
		</div>

		<div class="col-md-4">
			<div class="inner">
				<h2>Bus Hire</h2>
				<div class="feature-wrap">
                    <i class="fa fa-bus"></i>
				</div>
				<ul class="bxslider1">
					<li><h3>Step 1</h3>Fill the bus hire form and submit</li>
					<li><h3>Step 2</h3>That would be all</li>
					<li><h3>Step 3</h3>and we will contant you ASAP</li>
				</ul>
			</div>
		</div>

		<div class="col-md-4">
			<div class="inner">
				<h2>Time</h2>
				<div class="feature-wrap">
                    <i class="fa fa-clock-o"></i>
				</div>
				<br />
				<h2><?php echo date('h:i'); ?></h2><br /><br /><br />
			</div>
		</div>
	</div>
</div>

<div class="container" style="margin-top: 70px">
	<div class="row white-bg">
		<div class="col-md-4">
			<div class="services">
				<h2>Reserve Seat Online</h2><br />
				You can now make payments and reserve a seat of your choice online without bothering to come to our booking office.
				<br /><br /><a href="#" class="btn btn-danger">Read more</a>
			</div>
		</div>

		<div class="col-md-4">
			<div class="services">
				<h2>Satisfactory Service</h2><br />
				We pride with keeping to our departure time and maintaining a satisfactory road transport service with
				comfortable vehicles.
				<br /><br /><a href="#" class="btn btn-danger">Read more</a>
			</div>
		</div>

		<div class="col-md-4">
			<div class="services">
				<h2>Courier Service</h2><br />
				Autostart also runs a reliable and efficient courier service. We deliver safely and speedily to anywhere in Nigeria.
				<br /><br /><a href="#" class="btn btn-danger">Read more</a>
			</div>
		</div>
	</div>
</div>

<div style="height: 60px"></div>

<script>
$(document).ready(function() {
	var destination = [];
	destination['Lagos'] = ["Enugu", "Abuja", "Delta", "PortHarcout"];
	destination['Enugu'] = ["Abuja", "Lagos"];
	destination['PortHarcourt'] = ["Lagos", "Abuja"];
	destination['Abuja'] = ["Lagos", "Enugu"];
	destination['Delta'] = ["Lagos", "Abuja"];

	$("#origin").change(function() {
		var origin = $(this).val();
		var opt = '<option value="">-- Pick destination --</option>';
		$.each(destination[origin], function(i, val) {
			opt += "<option value='" + val + "'>" + val + "</option>\n";
		});
		$("#destination").html(opt);
	});
});
</script>
<?php require_once "includes/footer.php"; ?>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/plugins/jquery.bxslider.min.js"></script>
<script>
$(document).ready(function() {
	$('.bxslider').bxSlider({
		auto: true,
		speed: 1000,
		pause: 4500,
		responsive: true,
		autoControls: false
	});

	$('.bxslider1').bxSlider({
		auto: true,
		speed: 500,
		pause: 4000,
		autoDelay: 20,
		responsive: true,
		autoControls: false
	});
});


$('.date').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		todayHighlight: true,
		autoclose: true
});



$(window).load(function(){
	$('.slider').fractionSlider({
		'fullWidth': 			true,
		'controls': 			true,
		'pager': 				true,
		'responsive': 			true,
		'dimensions': 			"1000,400",
	    'increase': 			false,
		'pauseOnHover': 		true,
		'slideEndAnimation': 	true
	});
});
</script>
