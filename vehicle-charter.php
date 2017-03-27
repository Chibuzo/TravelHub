<?php
$page_title = "Vehicle hire and Charter Services";
require_once "includes/banner.php";
?>
<link href="css/datepicker.css" rel="stylesheet" />
<link href="css/datepicker3.css" rel="stylesheet" />
<style>
#feature {
	background: url('images/road-trip.jpg');
	background-size: cover;
	background-repeat: no-repeat;
	margin-top: -21px;
	min-height: 522px;
}

.div-chart-form {
    margin-top: 90px;
	padding: 30px 2px;
	background-color: rgba(0, 0, 0, 0.5);
}

.div-features {
    margin: auto;
    width: 60%;
    margin-top: 100px;
}

.div-features h2 {
	margin-bottom: 25px;
	font-weight: 400
}

.div-features h4 {
	font-size: 20px;
	font-weight: 400;
	margin-top: -3px;
	color: #333;
}

#phone-div {
	margin-top: 40px;
	margin-left: 25px;
	text-lign: center;
	font: 400 28px 'Open Sans', San-serif, Helvetica Neue, Tahoma;
	color: #333;
}


#features {
	margin-top: 60px;
	padding-bottom: 70px;
	font-weight: 300;
}

#features h3 {
	font-size: 24px;
	margin-bottom: 17px;
}

#features .col-md-4 div {
	padding: 5px 15px;
}


@media screen and (min-width: 200px) and (max-width: 600px) {
	body {
		margin-bottom: 0;	
	}
	
	.div-features {
		width: 100%;
		margin-top: 50px;
	}
	
	.div-features h2 {
		font-size: 28px;
		text-align: center;
		margin-bottom: 25px;
	}
	
	.div-features h4 {
		margin-top: 4px;
	}
	
	footer {
		position: relative;
	}
}
</style>

<div class="container-fluid" id="feature">
<div class="div-chart-form">
	<form action="" method="post" class="container" role="form" id="form-charter">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="alert alert-info hidden">
					Thank you! We have received your request. One of your agent will get in touch with you as soon as possible.
				</div>
				
				<div class="form-group" style="color: #fff">
					<label class="radio-inline">
						<input type="radio" name="service" id="charter" value="Charter" checked> Vehicle Charter
					</label>
					<label class="radio-inline">
						<input type="radio" name="service" id="hire" value="Hire"> Vehicle Hire
					</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<input type="text" name="c_name" id="customer_name" class="form-control" placeholder="Your name" />
				</div>

				<div class="form-group">
					<input type="text" name="c_phone" id="customer_number" class="form-control" placeholder="Your phone number" />
				</div>
			</div>
   
			<div class="col-md-3">
				 <div class="form-group">
					 <input type="text" name="email" id="email" class="form-control" placeholder="Email address" />
				 </div>
				 
				 <div class="form-group row">
					 <div class="col-md-7">
						 <select name="vehicle_type" class="form-control">
							 <option value="">Vehicle Type</option>
							 <option value="Hiace">Toyota Hiace</option>
							 <option value="Sienna">Sienna</option>
							 <option value="SUV">SUV</option>
							 <option value="Saloon">Saloon</option>
						 </select>
					 </div>
					 <div class="col-md-5">
						 <select name="num_of_vehicles" class="form-control">
							<option value="">No of vehicles</option>
							 <option value="1" selected="selected">1</option>
							 <option value="1">2</option>
							 <option value="3">3</option>
							 <option value="4">4</option>
							 <option value="5">5</option>
						 </select>
					 </div>
				 </div>
			</div>
			<div class="col-md-3">
				 <div class="form-group">
					 <input type="text" name="origin" class="form-control" placeholder="Departure location" />
				 </div>
		 
				 <div class="form-group">
					 <input type="text" name="destination" class="form-control" placeholder="Destination" />
				 </div>
			</div>
			<div class="col-md-3">
				 <div class="form-group">
					 <input type="text" name="trip_date" id="travel-date" class="form-control date" placeholder="Trip date" />
				 </div>
		 
				 <div class="form-group">
					 <input type="submit" class="btn btn-danger btn-fill btn-block" name="submit" class="form-control" value="Submit Request" />
				 </div>
			</div>
		</div>
	</form>	
</div>

<div class="row" style="margin-top: 50px">
	<div class="col-md-6 text-center" style="float: none; margin: auto;">
			<h3 style="color: #fff; font-weight: 700">Give us your trip details, we'll negotiate with the best operators to get you the best deals.</h3>
	</div>
</div>
</div>



<div class="container" id="features">
	<div class="row">
		<div class="col-md-4">
			<div>
				<h3>Inventory</h3>
				TravelHub provides customers with a wide array of travel options. From our list of reliable transport companies, our customers get the
				most relevant charter pertaining to vehicle charter and hire.
			</div>
		</div>

		<div class="col-md-4 right-border">
			<div>
				<h3>Best Deals</h3>
				Get affordable and reasonable prices on every service. Our exceptional relationship with transport companies, enables us negotiate and 
				provide our customers with the best deals on vehicles for charter or hire.   
			</div>
		</div>

		<div class="col-md-4">
			<div class="">
				<h3>No Service Fees</h3>
				TravelHub operates a zero-service charge policy for travelers. This means that our services are totally free for all road travelers. We offer
				convenient charter and hire services with absolutely no added or hidden costs. 
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<script>
	$(function() {
		$("#travel-date").datepicker({
			format: 'dd-mm-yyyy',
			keyboardNavigation: false,
			forceParse: false,
			todayHighlight: true,
			autoclose: true
		});
	});
</script>
<?php require_once "includes/footer.php"; ?>
<script>
$(document).ready(function() {
	$("#form-charter").submit(function(e) {
		e.preventDefault();
		var data = $(this).serialize() + '&op=add-charter';
		$("#form-charter input, select").prop("disabled", true);
		
		$.post('ajax/vehicle-charter.php', data, function(d) {
			if (d.trim() == 'Done') {
				$(".alert-info").removeClass('hidden');
				$("#form-charter input, select").prop("disabled", false);
				$("#form-charter")[0].reset();
			}
		});
	});
});
</script>