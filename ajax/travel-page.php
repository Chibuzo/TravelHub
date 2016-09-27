<?php

if (isset($_REQUEST['op'])) {
    if ($_REQUEST['op'] == 'get-travel-state-parks')
    {
        require_once "../api/models/parkmodel.class.php";
        require_once "../api/models/travelparkmap.class.php";
        $parkModel = new ParkModel();
        $travelParkMap = new TravelParkMap();

        $parks = $parkModel->getTravelParksByState($_POST['travel_id'], $_POST['state_id']);
        $tbody = "";
        foreach ($parks AS $park) {
            echo $park->status . '-';
            $status = $park->status == 1 ? 'Checked' : '';
            $online = $park->online == 1 ? 'Checked' : '';
            $tbody .= "<tr id='{$park->park_id}'>
                        <td>$park->park</td>
                        <td class='text-right'>" . $travelParkMap->getNumOfRoutesForPark($_POST['travel_id'], $park->park_id) . "</td>
                        <td>
                            <div class='onoffswitch'>
                                <input type='checkbox' data-toggle='modal' data-target='#confirmModal' class='onoffswitch-checkbox' id='{$park->park}-status' data-level='park' data-field='status' $status>
                                <label class='onoffswitch-label' for='{$park->park}-status'>
                                    <span class='onoffswitch-inner'></span>
                                    <span class='onoffswitch-switch'></span>
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class='onoffswitch'>
                                <input type='checkbox' data-toggle='modal' data-target='#confirmModal' class='onoffswitch-checkbox' id='{$park->park}-online' data-level='park' data-field='online' $online>
                                <label class='onoffswitch-label' for='{$park->park}-online'>
                                    <span class='onoffswitch-inner'></span>
                                    <span class='onoffswitch-switch'></span>
                                </label>
                            </div>
                        </td>
                        <td>{$park->address} <br> {$park->phone}</td>
                     </tr>";
        }
        echo $tbody;
    }
    elseif ($_REQUEST['op'] == 'alter-state-setting')
    {
        require_once "../api/models/travel.class.php";
        $travel = new Travel();
        $travel->updateStateSetting($_POST['travel_id'], $_POST['state_id'], $_POST['field'], $_POST['value']);
    }
    elseif ($_REQUEST['op'] == 'alter-park-setting')
    {
        require_once "../api/models/travel.class.php";
        $travel = new Travel();
        $travel->updateParkSetting($_POST['travel_id'], $_POST['park_id'], $_POST['field'], $_POST['value']);
    }
}