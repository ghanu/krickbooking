<?php

class Application_Model_EditBooking extends Application_Model_Booking
{

    /**
     * 
     * @param array $params
     * @return int || null
     */
    public function editBooking($params)
    {
        $result = '';
        $this->_buildExistingData(self::BOOKING_STATUS_BOOKED, $params);
        $this->_setExistingBookingId();
        if (!empty($this->getFkCustomer()) && !empty ($this->getFkBookingSlot()) && !empty($this->getIdBooking())) {
            $this->_buildExistingData(self::BOOKING_STATUS_CHANGED, $params);
            $this->_bookingMapperModel->save($this);
            $this->setIdBooking('');
        }
        $this->_buildInsertData(self::BOOKING_STATUS_BOOKED, $params);
        if (!empty($this->getFkCustomer()) && !empty ($this->getFkBookingSlot()) && $this->_checkDuplicateBooking()) {
            $result = $this->_bookingMapperModel->save($this);
        }
        return $result;
    }

    /**
     * @param string $statusName
     * @param array $params
     *
     * @return $this
     */
    protected function _buildExistingData($statusName, $params)
    {
        $customerId = $this->_getCustomerIdByEmail($params[Application_Model_Stadiumbooking::PARAM_EMAIL]);
        $bookingSlotId = $this->_getBookingSlotIdBySlotHours(
            $params[Application_Model_Stadiumbooking::PARAM_OLD_BOOKING_SLOT]
        );
        $bookingStatusId = $this->_getBookingStatusByStatusName($statusName);
    
        $this->setFkCustomer($customerId);
        $this->setFkBookingSlot($bookingSlotId);
        $this->setBookingdate($params[Application_Model_Stadiumbooking::PARAM_OLD_BOOKING_DATE]);
        $this->setFkBookingStaus($bookingStatusId);
        return $this;
    }
}

