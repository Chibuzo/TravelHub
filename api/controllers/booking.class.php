<?php

class Booking extends TravelHub
{
    private $params;

    public function __construct($param = null)
    {
        parent::__construct();
        $this->params = $param;
        $this->model = new BookingModel();
    }


    public function saveBooking()
    {
        // handle customer
        $customer = new Customer();
        $_customer = $customer->getCustomer('phone_no', $this->params['customer_phone']);
        $customer_id = $_customer['id'];
        if ($_customer == false) {
            $customer->customer_name     = $this->params['customer_name'];
            $customer->phone_no          = $this->params['customer_phone'];
            $customer->next_of_kin_phone = $this->params['next_of_kin_phone'];
            $customer_id                 = $customer->addNew($customer);
        }
        try {
            $this->model->externalBooking($this->params['trip_id'], $this->params['travel_date'], $this->params['departure_order'], $this->params['seat_no'], $customer_id, $this->params['channel']);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}