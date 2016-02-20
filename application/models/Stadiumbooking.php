<?php
/**
 * 
 * @author ghanu
 *
 */
class Application_Model_Stadiumbooking
{
    const PARAM_EMAIL = 'email';
    const PARAM_BOOKING_DATE = 'booking_date';
    const PARAM_BOOKING_SLOT = 'booking_slot';
    const PARAM_OLD_BOOKING_DATE = 'old_booking_date';
    const PARAM_OLD_BOOKING_SLOT = 'old_booking_slot';
    
    protected $_bookingModel;
    
    public function __construct()
    {
        $this->setBookingModel('Application_Model_Booking');
    }
    
    /**
     * 
     * @param array $params
     */
    public function createBooking($params)
    {
        $status = 'failed';
        if(!$this->_isValidateParams($params) || !$this->_isValidateDate($params[self::PARAM_BOOKING_DATE])) {
            return array (
                'status' => $status,
                'description' => 'Invalid Parameter or Values'
            );
        }
        try {
            $result = $this->_bookingModel->createBooking($params);
            if ($result) {
                $status = 'success';
                $description = 'Thanks for booking with us';
            } else {
                $status = 'failed';
                $description = 'Sorry You can not make more than one booking  or Invalid Email or booking slot';
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
     * return $this
     */
    public function getBookingModel()
    {
        if (null === $this->_bookingModel) {
            $this->_setBookingModel();
        }
        return $this->_bookingModel;
    }
    
    /**
     * @param string $bookingModel
     * 
     * @return $this
     */
    public function setBookingModel($bookingModel)
    {
        /*
         * @see new Application_Model_Booking()
         */
        $this->_bookingModel = new $bookingModel();
        return $this;
    }
    
    
    /**
     * 
     * @param array $params
     * 
     * @return boolean
     */
    protected function _isValidateParams($params)
    {
        if (!empty($params[self::PARAM_EMAIL]) && !empty($params[self::PARAM_BOOKING_SLOT]) 
        && !empty($params[self::PARAM_BOOKING_DATE])) {
            return true;
        }
        return false;
    }
    
    /**
     * 
     * @param string $date
     * @param string $format
     */
    protected function _isValidateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

}

