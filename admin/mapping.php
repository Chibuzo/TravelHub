<?php
session_start();
require_once("../includes/db_handle.php");
//require_once("fns.php");

require_once "../includes/banner.php";
echo "<div id='content'><a href='logout.php' class='pull-right'>[ Logout ]</a>";

// Check for authenticated user
if (@$_SESSION['page'] != 'mapping.php') {
	echo "<div class='alert alert-error'>You are not authorized to use this page, so leave.</div>";
	require_once "includes/footer.php";
	exit;
}

// Add routes
if (isset($_POST['add'])) {
	foreach ($_POST['s_name'] AS $name) {
		if (!empty($name)) {
			$s_name = filter($name);
			$DB_CONNECTION->query("INSERT INTO states_towns (name) VALUES ('$s_name')");
		}
	}
}
?>
<script src="../javascript/jquery.autocomplete.pack.js" type="text/javascript"></script>
<script src="../javascript/bootstrap-tab.js" type="text/javascript"></script>
<script type="text/javascript" src="mapping.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.autocomplete.css" media="all" />

<style>
.left, .right {width:44%; float:left; margin:15px; border:#ccc solid thin; padding:10px}
#show > div {padding:8px; border:#ccc solid thin;}
#show > div > span {width:65%; float:right; margintop:-3px; border:#fff solid thin}
#show {width:75%; float:left}
.remove_state {float:right; padding-right:5px; font-family:Verdana}
#optpane {float:left; width:20%; border-right:#ccc solid thin; height:70px}
#contentpane {float:left; width:70%; border:#ccc solid thin}

th {
	font:11px Verdana;
}

td {
	font:11px Verdana;
}
</style>

	<div class="tabbable tabs-left">
		<ul class="nav nav-tabs" style="width:22%">
			<li><a href='#state' data-toggle="tab">Add State</a></li>
			<li class="active"><a href='#route' data-toggle="tab">Manage route</a></li>
			<li><a href='#bus' data-toggle="tab">Add bus</a></li>
			<li><a href='#nysc' data-toggle="tab">Nysc / Law</a></li>
			<li><a href="editbus.php">Edit routes and fare</a></li>
		</ul>
		
		<div class="tab-content">
			<div class="tab-pane" id="state">
				<div class="head">Add state/Town</div><hr style="margin-top:3px">
				<form action="" method="post" class="form-horizontal">
					<p style="margin-top:20px">
					</p><div class="form-group">
						<label class="control-label">State</label>
						<div class="controls">	
							<input type="text" name="s_name[]" class="form-control">
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label">State</label>
						<div class="controls">	
							<input type="text" name="s_name[]" class="form-control">
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label">State</label>
						<div class="controls">	
							<input type="text" name="s_name[]" class="form-control">
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label">State</label>
						<div class="controls">	
							<input type="text" name="s_name[]" class="form-control">
						</div>
					</div>
					<p></p>
					<div class="controls"><input type="submit" class="btn btn-primary form-control" value=" Add State(s)" name="add"> &nbsp;
					<input type="reset" class="btn form-control btn-default" value="Clear">
					</div>
				</form>
			</div>
			
			<div class="tab-pane active" id="route">
				<div class="head">Mapping</div><hr style="margin-top:3px">
				<p>Pick State<br><input type="text" id="origin" name="origin" style="width:150px" class="form-control">
				<input type="text" id="destination" name="destination" style="width:150px" class="form-control">
				<input type="button" class="btn form-control btn-default btn-sm" style="margin-top:-10px" value="Add" id="add">
				</p><p></p><div id="show"></div><p></p>
				<p style="clear:both"><input type="submit" value=" Done " class="btn btn-primary form-control" id="done"></p>
			</div>
			
			<div class="tab-pane" id="bus">
				<div class="head">
					Add bus
					<span class="pull-right" style="font-size:15px"><a id="edit-buses" href="mapping.php">Edit buses</a></span>
				</div><hr style="margin-top:3px">
				
				
			</div>
			
			<div class="tab-pane" id="nysc">
				<div class="head">For Law School / NYSC</div>
				<hr>
				<div class="alert hide alert-warning" id="nysc_alert"></div>
				<form action="" method="post" class="form-horizontal" id="special-route-form">
					
					<div class="form-group">
						<label class="control-label">Source</label>
						<div class="controls">
							<select name="category">
								<option value="">--Select category--</option>
								<option value="Law">Law School</option>
								<option value="nysc">NYSC</option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label">Source</label>
						<div class="controls">
							<select name="source">
							<?php
								$db->query("SELECT name FROM states_towns");
								foreach ($db->stmt AS $row) {
									echo "\t<option value='{$row['name']}'>{$row['name']}</option>\n";
								}
							?>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label">Destination</label>
						<div class="controls">
							<select name="destination">
							<?php
								$db->query("SELECT name FROM states_towns");
								foreach ($db->stmt AS $row) {
									echo "\t<option value='{$row['name']}'>{$row['name']}</option>\n";
								}
							?>
							</select>
						</div>
					</div>
						
					<div class="form-group">
						<label class="control-label">Departure date/time</label>
						<div class="controls">
							<input type="text" name="departure" class="form-control">
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label">Town [ *nysc ]</label>
						<div class="controls">
							<input type="text" name="town" class="form-control">
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label">Fare</label>
						<div class="controls">
							<input type="text" name="fare" class="form-control">
						</div>
					</div>
					
					<div class="controls">
						<input type="submit" class="btn btn-primary form-control" value=" Save ">&nbsp;
						<input type="reset" value=" Reset " class="btn form-control btn-default">
					</div>
				</form>
			</div>
		</div>
	
	
</div>