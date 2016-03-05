//var BASE_URL = "http://localhost/travelhub/";

$(document).ready(function() {

	/*** Show seating arrangement ***/
	$('.vehicles').on('click', '.display-seats, .vehicle', function(e) {
		e.preventDefault();

		var $this = '';
		if ($(this).attr('class').split(" ")[0] == 'vehicle') {
			$this = $(this).find('.display-seats');
		} else {
			$this = $(this);
		}
		var vehicle_type_id = $this.data('vehicle_type_id');
		var num_of_seats = $this.data('num_of_seats');
		//var route_id     = $(this).data('route_id');
		var park_map_id = $this.data('park_map_id');
		var departure_order = $this.data('departure_order');
		var fare = $this.data('fare');
		var trip_id = $this.data('trip_id');
		var travel_id = $this.data('travel_id');
		var travel_date = $this.data('travel_date');

		// prevent reloading seats
		if ($('#show-seat_' + trip_id).html().length > 10 && $('#show-seat_' + trip_id).is(':hidden')) {
			$('#show-seat_' + trip_id).slideDown();
			return;
		} else if ($('#show-seat_' + trip_id).html().length > 10 && $('#show-seat_' + trip_id).is(':visible')) {
			$('#show-seat_' + trip_id).slideUp();
			return;
		} else {
			$.post('ajax/seating.php', {
				'vehicle_type_id' :vehicle_type_id,
				'num_of_seats':num_of_seats,
				//'route_id'    :route_id,
				'park_map_id' :park_map_id,
				'departure_order':departure_order,
				'fare'        :fare,
				'trip_id'     :trip_id,
				'travel_id'   :travel_id,
				'travel_date' :travel_date
			},
			function(d) {
				var height = '';
				if (num_of_seats > 15) height = "250px";
				else height = "+230px";
				$('#show-seat_' + trip_id).css('display', 'block').animate({height: height}, function() {
					$(this).html(d);
					//$this.next('.loading').css('visibility', 'hidden');
				});
			});
		}
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
		boarding_vehicle_id = $seating_parent.data('boarding_vehicle_id');

		if (seat_no.length < 1) {
			alert("Pick a seat before you continue");
			return false;
		}

		// confirm seat avaliability
		$.post('ajax/save_booking_details.php', {'op': 'reserve-seat', 'seat_no': seat_no, 'boarding_vehicle_id': boarding_vehicle_id}, function(d) {
			if (d.trim() == "2") {
				alert("Sorry, seat " + seat_no + " is no longer available. Please pick another seat.");
				// refresh seats
			} else {
				$.post('ajax/hold_details.php', {
					'vehicle_type_id': vehicle_type_id,
					'fare'       : fare,
					'trip_id'    : trip_id,
					'seat_no'    : seat_no,
					'travel_date': travel_date,
					//'num_of_seats': num_of_seats,
					//'travel_id'  : travel_id,
					'boarding_vehicle_id' : boarding_vehicle_id
				},
				function(d) {
					location.href = "details.php";
				});
			}
		});
	});


	$('.show-seat').on('click', '.glyphicon-remove', function() {
		//$(this).closest('div', '.vehicle').fadeOut();
		$(this).parents('.show-seat').slideUp(function() {
			//$(this).show();
		});
	});
});
