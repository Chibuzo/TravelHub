<?php

require_once '../api/models/user.class.php';
require_once '../api/models/travelparkmap.class.php';

?>
<div>
    <button type="submit" data-target="#userModal" data-travel-id="<?php echo $id; ?>" data-toggle="modal" class="btn btn-primary"><i class='fa fa-plus'></i> Add Admin</button>
</div>
<hr />
<?php
$user_mapper = new User();
$travel_park_map_mapper = new TravelParkMap();

$travel_admins = $user_mapper->getUserByTravel($id);
$travel_park_maps = $travel_park_map_mapper->getTravelParkMaps($id);

//show users if they have been added.
if (is_array($travel_admins) && count($travel_admins) > 0):
?>
    <h4 class="text-light-blue">Travel Users</h4>
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
if (is_array($travel_park_maps) && count($travel_park_maps) > 0):
    $i = 1;
?>
    <hr />
    <h4 class="text-light-blue">Travel Routes</h4>
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
        foreach ($travel_park_maps as $park_map) {
            printf("<tr><td>%d</td><td>%s</td><td>%s</td></tr>", $i, $park_map->origin_name . "({$park_map->origin_state})", $park_map->destination_name . "({$park_map->destination_state})");
            $i++;
        }

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