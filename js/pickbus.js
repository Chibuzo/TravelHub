//var BASE_URL = "http://localhost/travelhub/";

$(document).ready(function() {

	/*** Show seating arrangement ***/
	$('.vehicle').on('click', '.display-seats', function(e) {
		e.preventDefault();

		var $this = $(this);
		$this.next('.loading').css('visibility', 'visible');
		var vehicle_type_id  = $(this).data('vehicle_type_id');
		var num_of_seats = $(this).data('num_of_seats');
		var route_id     = $(this).data('route_id');
		var fare         = $(this).data('fare');
		var trip_id      = $(this).data('trip_id');
		var travel_date  = $(this).data('travel_date');

		$.post('ajax/seating.php', {
			'vehicle_type_id' :vehicle_type_id,
			'num_of_seats':num_of_seats,
			'route_id'    :route_id,
			'fare'        :fare,
			'trip_id'     :trip_id,
			'travel_date' :travel_date
		},
			function(d) {
				var height = '';
				if (num_of_seats > 15) height = "280px";
				else height = "+220px";
				$('#show-seat_' + trip_id).css('display', 'block').animate({height: height}, function() {
					$(this).html(d);
					$this.next('.loading').css('visibility', 'hidden');
				});
			}
		);
	});


	/*** Select/book and unselect seat [ Toggle ] ***/
	$('.show-seat').on('click', '.seat', function() {
		var seat_no = $(this).attr('id');
		var $this_parent = $(this).parents('.seat_arrangement');
		//var bus_id  = $(this).data('bus_id');
		var bus_id  = '1'; 	// Just keep this alive in case...
		var fare    = $this_parent.data('fare') + ' NGN';

		if ($(this).data('hidden') == 'no') {

			if ($this_parent.find('.picked_seat').text().length == 0) {
				$this_parent.find('.picked_seat').text(seat_no);
				$this_parent.find('.show_fare').text(fare);
			} else if ($this_parent.find('.picked_seat').text() != seat_no) { // Check if there's an already selected seat
				$('div.seat').css('background-image', 'url("images/seat.gif")').data('hidden', 'no');
				$this_parent.find('.picked_seat').text(seat_no);
				$this_parent.find('.show_fare').text(fare);
			}
			$(this).css('background-image', 'url("images/selected_seat.gif")');
			$this_parent.find('#show_fare').text(fare);
			$(this).data('hidden', 'Yes');
		} else {
			$(this).css('background-image', 'url("images/seat.gif")');
			$this_parent.find('.picked_seat').text('');
			$this_parent.find('.show_fare').text('');
			$(this).removeData('hidden').data('hidden', 'no');
		}
	});

 /*** Proceed to customer details page ***/
	$('.vehicle, .show-seat').on('click', '.continue', function(e) {
		e.preventDefault();

		var $seating_parent = $(this).parents('.seat_arrangement');

		var boarding_vehicle_id, num_of_seats = null;
		var fare        = $seating_parent.data('fare');
		var trip_id     = $seating_parent.data('trip_id');
		var vehicle_type_id = $seating_parent.data('vehicle_type_id');
		var travel_date = $seating_parent.data('travel_date');
		var seat_no     = $seating_parent.find('.picked_seat').text();
		var boarding_vehicle_id = $seating_parent.data('boarding_vehicle_id');

		if (seat_no.length < 1) {
			alert("Pick a seat before you continue");
			return false;
		}

		$.post('ajax/hold_details.php', {
			'vehicle_type_id': vehicle_type_id,
			'fare'       : fare,
			'trip_id'    : trip_id,
			'seat_no'    : seat_no,
			'travel_date': travel_date,
			'num_of_seats': num_of_seats,
			//'travel_id'  : travel_id,
			'boarding_vehicle_id' : boarding_vehicle_id
		},
			function(d) {
				location.href = "details.php";
			}
		);
	});


	$('.show-seat').on('click', '.glyphicon-remove', function() {
		$(this).closest('div', '.bus').fadeOut();
		$(this).parents('.show-seat').slideUp();
	});
});
