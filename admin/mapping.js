$(document).ready(function() {
	
	/*** Add route to travel [ main add handler ] ***/
	$("#show").on('click', '.add_travel', function() {
		var route_code = $(this).parents('div').attr('id');
		var travel_id = $(this).parents('span').find("input[id^=travel_]").data('id');
		$.post('ajax.php', {'route_code':route_code, 'travel_id':travel_id, op:'add_route_to_travel'});
	});
	
	/*** Get all the destinations for the selected origin ***/
	$("#origin").keypress(function(e) {
		if (e.which === 13) {
			$.get('ajax.php', {op:'mapped', state: $("#origin").val()}, function(d) {
				$("#show").html(d);
			});
		}
	});
	
	
	/*** Add bus ***/
	$("#add_bus").submit(function(e) {
		e.preventDefault();
		var data = $(this).serialize();
		$.post('ajax.php', data + '&op=add_bus', function(d) {
			if (d.trim() == 'done') {
				$('.alert').text("Operation successful").show().fadeOut(7000);
			}
		});
	});
	
	/*** Edit buses ***/
	$('#edit-buses').click(function(e) {
		e.preventDefault();
		$('#bus form').hide();
		
		$.get('ajax.php', {'op':'edit-buses'}, function(d) {
			$('#bus').append(d);
			$('#edit-buses').text('<< Back')
		});
	});
	
	
	/*** Remove bus ***/
	$('.delete').click(function(e) {
		e.preventDefault();
		if (confirm("Are you sure you want to remove this bus?")) {
			var $this = $(this);
			var id = $this.attr('id');
			$.post('ajax.php', {'op':'remove-bus', 'id':id}, function(d) {
				if (d.trim() == 'Done') {
					$this.parents('tr').fadeOut();
				}
			});
		}
	});
	
	
	/*** Add law/nysc route  ***/
	$('#special-route-form').submit(function(e) {
		e.preventDefault();
		
		$.post('ajax.php', $(this).serialize() + '&op=add_special_route', function(d) {
			if (d.trim() == "Saved") {
				$('#nysc_alert').addClass('alert-success').html("Route added").fadeIn("fast").fadeOut(8000);
			}
		});
	});
});
