<?php

class Application_Model_StadiumEditBooking extends Application_Model_Stadiumbooking
{

    
    public function __construct()
    {
        $this->setBookingModel('Application_Model_EditBooking');
    }
    
    /**
     *
     * @param array $params
     */
    public function editBooking($params)
    {
        $status = 'failed';
        if(!$this->_isValidateParams($params) 
            || !$this->_isValidateAdditionalParameter($params) 
            || !$this->_isValidateDate($params[self::PARAM_BOOKING_DATE])) {
            return array (
                'status' => $status,
                'description' => 'Invalid Parameter or Values'
            );
        }
        try {
            $result = $this->_bookingModel->editBooking($params);
            if ($result) {
                $status = 'success';
                $description = 'Thanks for booking with us';
            } else {
                $status = 'failed';
                $description = 'Sorry You can not edit your booking ';
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return array(
            'status' => $status,
            'description' => $description
        );
    }

    /**
     *
     * @param array $params
     *
     * @return boolean
     */
    protected function _isValidateAdditionalParameter($params)
    {
        if (!empty($params[self::PARAM_EMAIL]) && !empty($params[self::PARAM_OLD_BOOKING_DATE])
            && !empty($params[self::PARAM_OLD_BOOKING_SLOT])) {
                return true;
            }
            return false;
    }
}

