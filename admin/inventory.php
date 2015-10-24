<?php
session_start();

require_once "../includes/banner.php";
require_once "../includes/db_handle.php";
?>
<style>
.i-form {
	width: 50%;
	margin-left: 80px;
}

.alert{
	display: none;
}

.oya-tab {
	margin-top: 20px;
}

.tab-pane {
	background-color: #fff;
	padding: 10px;
}

.oya-set {
	border: #ccc solid thin !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
}

.oya-set legend {
	font-size: 1.2em !important;
	text-align: left !important;
	width: auto;
	padding:0 10px;
	border-bottom:none;
}

select {
	width: 250px !important;
	float: left;
}
</style>
<div class="container">
	<div class="row oya-tab">
		<div class="col-md-12">
			<ul class="nav nav-tabs pull-left">
				<li class="active"><a href="#add" data-toggle="tab">Add Inventory</a></li>
				<li><a href="#edit" data-toggle="tab">Edit Inventory</a></li>
			</ul>
		</div>
	</div>
	
	<div class="tab-content">
		<div class="tab-pane active" id="add">
			<div class="row">
				<div class="col-md-6">
					<h3>Active Operators</h3>
					<table class="table table-striped table-condensed">
						<thead><tr><th>Operator</th><th>ID</th></tr></thead>
						<tbody>
						<?php
							foreach ($db->query("SELECT * FROM travels") AS $row) {
								echo "<tr><td>{$row['company_name']}</td><td>{$row['id']}</td></tr>";
							}
						?>
						</tbody>
					</table>
				</div>
			
				<div class="col-md-6">
					<h3>Functional Parks</h3>
					<table class="table table-striped table-condensed">
						<thead><tr><th>Park</th><th>ID</th></tr></thead>
						<tbody>
						<?php
						foreach ($db->query("SELECT * FROM boarding_points") AS $row) {
							echo "<tr><td>{$row['terminal_name']}</td><td>{$row['id']}</td></tr>";
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="row"><br />
				<div class="col-md-6">
					<fieldset class="oya-set">
						<legend>Upload Inventory from here</legend>
						<form role'form' action='readexcel.php' method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label for="inventory_xls">Upload Excel file</label>
								<input type="file" name="inventory_xls" />
								<p>It's very easy to mess this up.</p>
							</div>
							<input type="submit" name="submit_inventory" value="Upload inventory" class="btn btn-primary" />
						</form>
					</fieldset>
				</div>
			</div>
		</div>
	
		<div class="row tab-pane" id="edit">
			<div class=pull-right">
				<form action='' method="post" role="form">
					<div class=form-group">
						<select class="form-control" name="travel_id">
							<?php
								foreach ($db->query("SELECT * FROM travels") AS $row) {
									echo "<option value='{$row['id']}'>{$row['company_name']}</option>";
								}
							?>
						</select>
						<input type="submit" value="Filter" class="btn btn-primary" />
					</div>
			</div>
		
			<h3>All Inventories</h3>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
					<th>Travel</th>
					<th>Route</th>
					<th>Bus type</th>
					<th>Utils</th>
					<th>Seats</th>
					<th>Park</th>
					<th>Time</th>
					<th>Fare</th>
					<th colspan='2'>Action</th>
				</tr>
				</thead>
				<tbody>
				<?php
					$terminal_id = isset($_REQUEST['travel_id']) ? $_REQUEST['travel_id'] : 1;
					$param = array('travel_id' => $terminal_id);
					
					$sql = "SELECT b.*, company_name, route FROM buses AS b
							JOIN travels AS t ON t.id = b.travel_id
							JOIN routes AS r ON r.id = b.route_id
							WHERE travel_id = :travel_id 
							ORDER BY travel_id";
		
					foreach ($db->query($sql, $param) AS $row) {
						extract($row);
						echo "<td>{$company_name}</td>
							<td>{$route}</td>
							<td>{$bus_type}</td>
							<td class='editable'>{$amenities}</td>
							<td>{$seats}</td>
							<td>Jibowu</td>
							<td>{$departure_time} {$period}</td>
							<td>{$fare}</td>
							<td><a href='editbus.php?id=$id&op=edit' class='edit' title='Edit'><span class='glyphicon glyphicon-edit'></span></a></td>
							<td><a href='' class='delete' id='{$id}' title='Delete'><span class='glyphicon glyphicon-remove'></span></a></td>
						</tr>";
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php require_once "../includes/footer.php"; ?>
<script type="text/javascript" src="mapping.js"></script>