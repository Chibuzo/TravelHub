<?php

require_once '../api/models/user.class.php';
require_once '../api/models/travelroute.class.php';

?>
<div>
    <button type="submit" data-target="#userModal" data-travel-id="<?php echo $id; ?>" data-toggle="modal" class="btn btn-primary"><i class='fa fa-plus'></i> Add Admin</button>
</div>
<hr />
<?php
$user_mapper = new User();
$travel_route_mapper = new TravelRoute();

$travel_admins = $user_mapper->getUserByTravel($id);
$travel_routes = $travel_route_mapper->getTravelRoutes($id);

//show users if they have been added.
if (is_array($travel_admins) && count($travel_admins) > 0):
?>
<table id="travel_admin_tbl" class="table tablebordered table-striped">
    <thead>
    <tr>
        <th width='30'>S/No</th>
        <th>Full Name</th>
        <th>Username</th>
        <th>User Type</th>
    </tr>
    </thead>
    <tbody id="travel_admin_rows">
    <?php
    $i = 1;
    foreach ($travel_admins as $admin) {
        printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td></tr>", $i, $admin->fullname, $admin->username, $admin->user_type);
        $i += 1;
    }
    ?>
    </tbody>
</table>
<?php else: ?>
<div>
    <div class="callout callout-warning">
        <p>No Users created for Travel.</p>
    </div>
</div>
<hr />
<?php endif;

//show routes if they have been added
if (is_array($travel_routes) && count($travel_routes) > 0):
?>
<table class="table tablebordered table-striped">
    <thead>
    <tr>
        <th width='30'>S/No</th>
        <th>Origin</th>
        <th>Destination</th>
    </tr>
    </thead>
    <tbody id="routes">
    <?php
    var_dump($travel_routes);
    ?>
    </tbody>
</table>
<?php else: ?>
    <div>
        <div class="callout callout-warning">
            <p>No Routes created for Travel.</p>
        </div>
    </div>
    <hr />
<?php endif; ?>