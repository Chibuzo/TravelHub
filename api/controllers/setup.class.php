<?php

class Setup extends TravelHub
{
    private $params;
    private $setup = array();

    public function __construct($param = null)
    {
        parent::__construct();
        $this->params = $param;
        $this->model = new SetupModel();
    }


    public function init()
    {
        // get travel details
        $this->setup['travel'] = $this->model->getTravelDetails($this->params['travel_id'], $this->params['park_id']);
        $this->setup['data'] = $this->model->getWorkingData($this->params['travel_id'], $this->params['park_id']);
        return $this->setup;
    }


    public function addParkMap()
    {
        return $this->model->addParkMap($this->params['origin'], $this->params['destination'], $this->params['travel_id']);
    }


    public function addTrip()
    {
        return $this->model->addTrip($this->params['park_map_id'], $this->params['departure'], $this->params['travel_id'], $this->params['state_id'], $this->params['vehicle_type_id'], $this->params['amenities'], $this->params['departure_time'], $this->params['fare'], 't');
    }


    public function updateTrip()
    {
        return $this->model->updateTrip($this->params['trip_id'], $this->params['amenities'], $this->params['fare'], 't');
    }
}