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


    //public function getWorkingData()
}