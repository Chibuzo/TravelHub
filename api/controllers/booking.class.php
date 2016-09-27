<?php

class Booking extends TravelHub
{
    private $params, $issue;

    public function __construct($param = null)
    {
        parent::__construct();
        $this->params = $param;
        $this->model = new BookingModel();
        $this->issue = new BookingIssues();
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
            $status = $this->model->externalBooking($this->params['trip_id'], $this->params['travel_date'], $this->params['departure_order'], $this->params['seat_no'], $customer_id, $this->params['channel']);
            return ($status === true) ? "Done" : "Error";
        } catch (Exception $e) {
            $this->issue->logFailedPush($this->params['trip_id'], $this->params['travel_date'], $this->params['seat_no'], $this->params['departure_order'], $this->params['customer_name'], $this->params['customer_phone'], $this->params['next_of_kin_phone'], $this->params['channel'], '', $e->getMessage());
            return $e->getMessage();
        }
    }


    public function fixFailedBooking()
    {
        foreach ($this->params['data'] AS $bk) {
            // handle customer
            $customer = new Customer();
            $_customer = $customer->getCustomer('phone_no', $bk->cust_phone);
            $customer_id = $_customer['id'];
            if ($_customer == false) {
                $customer->customer_name     = $bk->cust_name;
                $customer->phone_no          = $bk->cust_phone;
                $customer->next_of_kin_phone = $bk->next_of_kin_phone;
                $customer_id                 = $customer->addNew($customer);
            }
            try {
                $this->model->externalBooking($bk->trip_id, $bk->travel_date, $bk->departure_order, $bk->seat_no, $customer_id, 'offline');
            } catch (Exception $e) {
                $this->issue->logSynchFailure($bk->trip_id, $bk->travel_date, $bk->departure_order, $bk->seat_no, $e->getMessage());
            }
        }
        return "Done";
    }


    public function getFailedBookingPush()
    {
        $this->issue->pushFailedPush($this->params['terminal_sub_id']);
    }


    public function cancelTicket()
    {
        $this->model->cancelTicketFromDepot($this->params['trip_id'], $this->params['departure_order'], $this->params['travel_date'], $this->params['seat_no']);
    }


    public function reopenVehicle()
    {
        $boarding_vehicle_id = $this->model->getBoardingVehicleId($this->params['trip_id'], $this->params['departure_order'], $this->params['travel_date']);
        if (is_numeric($boarding_vehicle_id)) {
            $vehicle = new VehicleModel();
            $vehicle->reopenVehicle($boarding_vehicle_id);
        }
    }
}