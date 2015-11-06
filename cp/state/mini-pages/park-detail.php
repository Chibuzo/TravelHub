<?php

require_once '../api/models/user.class.php';
require_once '../api/models/travelroute.class.php';

$db->query("SELECT * FROM parks WHERE id = :id", array('id' => $id));
$park = $db->fetch('obj');
?>
<form method="post">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <select name="origin" id="origin" class="form-control" disabled="disabled" required>
                    <option value="">-- Origin ( From ) --</option>
                    <?php
                    $states = '';
                    $db->query("SELECT * FROM states ORDER BY state_name");
                    $_states = $db->fetchAll('obj');
                    foreach ($_states AS $st) {
                        printf("<option value='%d'>%s (%s)</option>", $st->id, $st->state_name, $park->park);
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <select name="destination" id="destination" class="form-control" required>
                    <option value="">- Destination (State) -</option>
                    <?php
                    foreach ($_states AS $st) {
                        printf("<option value='%d'>%s</option>", $st->id, $st->state_name);
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <select name="destination" id="destination" class="form-control" required>
                    <option value="">-- Destination (Zone) --</option>
                    <?php

                    ?>
                </select>
            </div>
        </div>
        <input type="hidden" name="add_route" value="yes" />

        <div class="col-md-1">
            <button type="submit" name="addRoute" class="btn bg-olive"><i class='fa fa-plus'></i> Add</button>
        </div>
    </div>
</form>