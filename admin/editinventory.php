<div class="i-form">
		<h3>Add Inventory</h3>
		
		<form id="add_bus" method="post" class="form-horizontal">
			<div class="form-group">
				<label class="control-label">Travel</label>
				<div class="controls">
					<select name="travel" class="form-control">
			<?php
				$db->query("SELECT id, company_name FROM travels");
				foreach ($db->stmt AS $row) {
					echo "<option value='{$row['id']}'>{$row['company_name']}</option>\n";
				}
			?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label">Boarding point</label>
				<div class="controls">
					<select name="terminal_id" class="form-control">
						<option value="">Select boarding point</option>
						<?php
							$db->query("SELECT id, terminal_name FROM boarding_points");
							foreach ($db->stmt AS $row) {
								echo "\t<option value='{$row['id']}'>{$row['terminal_name']}</option>\n";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label">Bus type</label>
				<div class="controls">
					<select name="bus_type" class="form-control">
						<option value="">-- Select bus type --</option>
					<?php
						/*** Auto select bus position onloading ***/
						//$sql = "SELECT id, num_of_seats, destination";
					
						$db->query("SELECT name, number_of_seats FROM bus_types");
						foreach ($db->stmt AS $type) {
							echo "\t<option value='{$type['name']}'>{$type['name']}</option>\n";
						}
						echo "</select>";
					?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label">Amenities</label>
				<div class="controls">
					<input type="text" name="amenities" class="form-control">
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label">Route</label>
				<div class="controls">
					<select name="route" class="form-control">
						<?php
							$db->query("SELECT id, route FROM routes");
							foreach ($db->stmt AS $row) {
								echo "<option value='{$row['id']}'>{$row['route']}</option>\n";
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label">Seats</label>
				<div class="controls">
					<input type="text" name="seats" class="form-control">
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label">Departure time</label>
				<div class="controls">
					<input type="text" name="departure_time" placeholder="00:00" style="width:100px; float: left" class="form-control">
					<select name="period" style="width:151px" class="form-control">
						<option value="">Choose</option>
						<option value="Am">Morning [ AM ]</option>
						<option value="Pm">Night [ PM ]</option>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="control-label">Fare</label>
				<div class="controls">
					<input type="text" name="fare" class="form-control">
				</div>
			</div>
			
			<div class="form-group hidden">
				<label class="control-label">Children's fare</label>
				<div class="controls">
					<input type="text" name="child_fare" class="form-control">
				</div>
			</div>
			
			
				<input type="submit" name="bus" class="btn  btn-primary form-control" value="Add Bus"> &nbsp;
				<div class="alert alert-success"></div>
		</form>
	</div>
	</div>