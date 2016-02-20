<?php

class Application_Model_StadiumCancelBooking extends Application_Model_Stadiumbooking
{


    public function __construct()
    {
        $this->setBookingModel('Application_Model_CancelBooking');
    }
    
    /**
     *
     * @param array $params
     */
    public function cancelBooking($params)
    {
        $status = 'failed';
        if(!$this->_isValidateParams($params) || !$this->_isValidateDate($params[self::PARAM_BOOKING_DATE])) {
            return array (
                'status' => $status,
                'description' => 'Invalid Parameter or Values'
            );
        }
        try {
            $result = $this->_bookingModel->cancelBooking($params);
            if ($result) {
                $status = 'success';
                $description = 'Thanks for cancel your booking';
            } else {
                $status = 'failed';
                $description = 'Sorry You can not mackcanel';
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return array(
            'status' => $status,
            'description' => $description
        );
    }
}

