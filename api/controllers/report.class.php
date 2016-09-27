<?php

class Report extends TravelHub
{
    private $params;

    public function __construct($param = null)
    {
        parent::__construct();
        $this->params = $param;
        $this->model = new ReportModel();
    }


    public function saveManifestAccount()
    {
        $book = new BookingModel();
        $boarding_vehicle_id = $book->getBoardingVehicleId($this->params['trip_id'], $this->params['departure_order'], $this->params['travel_date']);
        if (is_numeric($boarding_vehicle_id)) {
            $this->model->saveManifestAccount($boarding_vehicle_id, $this->params['feeding'], $this->params['fuel'], $this->params['scouters'], $this->params['expenses'], $this->params['load']);

            // close vehicle
            $vehicle = new VehicleModel();
            $vehicle->closeVehicle($boarding_vehicle_id);
        }
    }

}