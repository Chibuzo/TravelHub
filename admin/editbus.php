<?php
session_start();
require_once "../includes/banner.php";
require_once "../includes/db_handle.php";
?>

<div class='container'>
<h3>Edit selected Inventory</h3><hr />
	
<a href='logout.php' class='pull-right'>[ Logout ]</a>
<a href='inventory.php' class='pull-right'>[ Go back ]</a>
<?php
// Check for authenticated user
#if (@$_SESSION['page'] != 'mapping.php') {
#	echo "<div class='alert alert-danger'>You are not authorized to use this page, so leave.</div>";
#}

if (isset($_REQUEST['op'])) {	
	if ($_REQUEST['op'] == 'edit') {
		$sql = "SELECT b.*, company_name, terminal_name, route FROM buses AS b
			JOIN travels AS t ON t.id = b.travel_id
			JOIN routes AS r ON r.id = b.route_id
			JOIN boarding_points bp ON bp.id = b.terminal_id
			WHERE b.id = :id";
			
		$db->query($sql, array('id' => $_REQUEST['id']));
		$data = $db->fetch();
		extract($data);
?>
		
	<form action='?op=update' method='post' class='form-horizontal' role='form'>
		<div class="form-group">
			<label class="col-sm-2 control-label">Travel</label>
			<div class="col-sm-4">
				<select name="travel_id" class="form-control">
					<?php
						foreach ($db->query("SELECT id, company_name FROM travels") AS $row) {
							if ($company_name == $row['company_name']) $attr = "selected";
							echo "<option value='{$row['id']}' $attr>{$row['company_name']}</option>\n";
							$attr = '';
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label">Boarding point</label>
			<div class="col-sm-4">
				<select name="terminal_id" class="form-control">
					<option value="">Select boarding point</option>
					<?php
						foreach ($db->query("SELECT id, terminal_name FROM boarding_points") AS $row) {
							if ($terminal_name == $row['terminal_name']) $attr = 'selected';
							echo "\t<option value='{$row['id']}' $attr>{$row['terminal_name']}</option>\n";
							$attr = '';
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label">Bus type</label>
			<div class="col-sm-4">
				<select name="bus_type" class="form-control">
					<option value="">-- Select bus type --</option>
				<?php
					foreach ($db->query("SELECT name, number_of_seats FROM bus_types") AS $row) {
						if ($bus_type == $type['name']) $attr = 'selected';
						echo "\t<option value='{$row['name']}' $attr>{$row['name']}</option>\n";
						$attr = '';
					}
					echo "</select>";
				?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label">Amenities</label>
			<div class="col-sm-4">
				<input type="text" name="amenities" value="<?php echo $amenities; ?>" class="form-control">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label">Route</label>
			<div class="col-sm-4">
				<select name="route_id" class="form-control">
					<?php
						foreach ($db->query("SELECT id, route FROM routes") AS $row) {
							if ($route == $row['route']) $attr = 'selected';
							echo "<option value='{$row['id']}' $attr>{$row['route']}</option>\n";
							$attr = '';
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label">Seats</label>
			<div class="col-sm-4">
				<input type="text" name="seats" value="<?php echo $seats;?>" class="form-control">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label">Departure time</label>
			<div class="col-sm-4">
				<input type="text" name="departure_time" value="<?php echo $departure_time; ?>" style="width:100px" class="form-control pull-left">
				<select name="period" style="width:151px" class="form-control">
					<option value="">Choose</option>
					<option value="Am">Morning [ AM ]</option>
					<option value="Pm">Night [ PM ]</option>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label">Fare</label>
			<div class="col-sm-4">
				<input type="text" name="fare" value="<?php echo $fare; ?>" class="form-control">
			</div>
		</div>
		
		<input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" class="form-control">
			
		<div class="form-group">
			<div class="col-md-offset-2 col-sm-4">
				<input type="submit" value=" Update " class="btn btn-primary form-control">&nbsp; &nbsp;
				<input type="reset" value=" Reset " class="btn form-control btn-default">
			</div>
		</div>

<?php }
	elseif ($_REQUEST['op'] == 'update')
	{
		$sql = "UPDATE buses SET
					travel_id = :travel_id,
					terminal_id = :terminal_id,
					bus_type = :bus_type,
					amenities = :amenities,
					route_id = :route_id,
					seats = :seats,
					departure_time = :departure_time,
					fare = :fare
				WHERE id = :id";
		
		extract($_POST);
		$param = array(
			'travel_id' => $travel_id,
			'terminal_id' => $terminal_id,
			'bus_type' => $bus_type,
			'amenities' => $amenities,
			'route_id' => $route_id,
			'seats' => $seats,
			'departure_time' => $departure_time,
			'fare' => $fare,
			'id' => $id
		);
		
		if ($db->query($sql, $param))
			echo "<div class='alert alert-success'>Operation successful <a href='inventory.php'>Click here</a> to go back</div>";
	}
}
echo '</div>';

?>