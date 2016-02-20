<?php

class Application_Model_Booking
{
    protected $_id_booking;
    protected $_fk_customer;
    protected $_fk_booking_slot;
    protected $_booking_date;
    protected $_fk_booking_status;
    protected $_created_at;
    protected $_updated_at;
    protected $_bookingMapperModel;
    
    const BOOKING_STATUS_BOOKED = 'booked';
    const BOOKING_STATUS_CANCEL = 'cancel';
    const BOOKING_STATUS_CHANGED = 'changed';
    
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
        $this->_setBookingMapperModel();
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid booking property');
        }
        $this->$method($value);
    }
    
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid booking property');
        }
        return $this->$method();
    }
    
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    /**
     * 
     * @param string $idBooking
     * @return Application_Model_Booking
     */
    public function setIdBooking($idBooking)
    {
        $this->_id_booking = (string) $idBooking;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getIdBooking()
    {
        return $this->_id_booking;
    }
    
    /**
     * 
     * @param int $fkCustomer
     * @return Application_Model_Booking
     */
    public function setFkCustomer($fkCustomer)
    {
        $this->_fk_customer = (int) $fkCustomer;
        return $this;
    }
    
    /**
     * 
     * @return int
     */
    public function getFkCustomer()
    {
        return $this->_fk_customer;
    }
    
    /**
     *
     * @param int $fkBookingSlot
     * @return Application_Model_Booking
     */
    public function setFkBookingSlot($fkBookingSlot)
    {
        $this->_fk_booking_slot = (int) $fkBookingSlot;
        return $this;
    }
    
    /**
     *
     * @return int
     */
    public function getFkBookingSlot()
    {
        return $this->_fk_booking_slot;
    }
    
    /**
     *
     * @param string $bookingStatus
     * @return Application_Model_Booking
     */
    public function setFkBookingStaus($fkBookingStatus)
    {
        $this->_fk_booking_status = (string) $fkBookingStatus;
        return $this;
    }
    
    /**
     *
     * @return string
     */
    public function getFkBookingStatus()
    {
        return $this->_fk_booking_status;
    }
    
    /**
     *
     * @param string $bookingDate
     * @return Application_Model_Booking
     */
    public function setBookingdate($bookingDate)
    {
        $this->_booking_date = $bookingDate;
        return $this;
    }
    
    /**
     *
     * @return string
     */
    public function getBookingDate()
    {
        return $this->_booking_date;
    }
    
    /**
     * 
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->_created_at = $createdAt;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->_created_at;
    }
    
    /**
     *
     * @param string $updateddAt
     */
    public function setUpdatedAt($updateddAt)
    {
        $this->_updated_at = $updateddAt;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->_updated_at;
    }
    
    /**
     * 
     * @param array $params
     * @return int
     */
    public function createBooking($params) 
    {
        $result = '';
        $this->_buildInsertData(self::BOOKING_STATUS_BOOKED, $params);
        if (!empty($this->getFkCustomer()) && !empty ($this->getFkBookingSlot()) && $this->_checkDuplicateBooking()) {
            $result = $this->_bookingMapperModel->save($this);
        }
        return $result;
    }
    
    /**
     * @return boolean
     */
    protected function _checkDuplicateBooking()
    {
        $result = $this->_bookingMapperModel->toCheckDuplicateBookingRow($this);
        return $result;
    }
    
    /**
     * @param string $statusName
     * @param array $params
     * 
     * @return $this
     */
    protected function _buildInsertData($statusName, $params)
    {
        $customerId = $this->_getCustomerIdByEmail($params[Application_Model_Stadiumbooking::PARAM_EMAIL]);
        $bookingSlotId = $this->_getBookingSlotIdBySlotHours(
            $params[Application_Model_Stadiumbooking::PARAM_BOOKING_SLOT]
        );
        $bookingStatusId = $this->_getBookingStatusByStatusName($statusName);
        
        $this->setFkCustomer($customerId);
        $this->setFkBookingSlot($bookingSlotId);
        $this->setBookingdate($params[Application_Model_Stadiumbooking::PARAM_BOOKING_DATE]);
        $this->setFkBookingStaus($bookingStatusId);
        return $this;
    }
    

    /**
     * To set setIdBooking()
     */
    protected function _setExistingBookingId()
    {
        $result = $this->_bookingMapperModel->getExistingBookingRow($this);
        if (!empty($result)) {
            $this->setIdBooking($result->id_booking);
        }
    }
    
    /**
     * 
     * @param string $email
     * 
     * @return int
     */
    protected function _getCustomerIdByEmail($email)
    {
        $customerMapperModel = new Application_Model_CustomerMapper();
        $customerRow = $customerMapperModel->getCustomerIdByEmail($email);
        if (!empty($customerRow)) {
            return $customerRow->id_customer;
        }
        return '';
    }
    
    /**
     * 
     * @param string $slotHours
     * 
     * @return int
     */
    protected function _getBookingSlotIdBySlotHours($slotHours)
    {
        $bookingSlotMapper = new Application_Model_BookingSlotMapper();
        $bookingSlotRow = $bookingSlotMapper->getBookingSlotIdBySlotHours($slotHours);
        if (!empty($bookingSlotRow)) {
            return $bookingSlotRow->id_booking_slot;
        }
        return '';
    }
    
    /**
     *
     * @param string $statusName
     *
     * @return int
     */
    protected function _getBookingStatusByStatusName($statusName)
    {
        $bookingStatusMapper = new Application_Model_BookingstatusMapper();
        $bookingStatusRow = $bookingStatusMapper->getBookingStatusByStatusName($statusName);
        if (!empty($bookingStatusRow)) {
            return $bookingStatusRow->id_booking_status;
        }
        return '';
    }
    
    /**
     * return $this
     */
    protected function _getBookingMapperModel()
    {
        if (null === $this->_bookingMapperModel) {
            $this->_setBookingMapperModel();
        }
        return $this->_bookingMapperModel;
    }
    
    /**
     *
     * @return $this
     */
    protected function _setBookingMapperModel()
    {
        $this->_bookingMapperModel = new Application_Model_BookingMapper();
        return $this;
    }

}

