<?php

class StadiumbookingController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function makebookingAction()
    {
        $params = $this->getAllParams();
        $stadiumBookingModel = new Application_Model_Stadiumbooking();
        $result = $stadiumBookingModel->createBooking($params);
        echo json_encode($result);
    }

    public function editbookingAction()
    {
        $params = $this->getAllParams();
        $stadiumEditBookingModel = new Application_Model_StadiumEditBooking();
        $result = $stadiumEditBookingModel->editBooking($params);
        echo json_encode($result);
    }

    public function cancelbookingAction()
    {
        $params = $this->getAllParams();
        $stadiumCancelBookingModel = new Application_Model_StadiumCancelBooking();
        $result = $stadiumCancelBookingModel->cancelBooking($params);
        echo json_encode($result);
    }


}







