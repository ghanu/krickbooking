<?php

class Application_Model_CancelBooking extends Application_Model_Booking
{

    public function cancelBooking($params) 
    {
        $result = '';
        $this->_buildInsertData(self::BOOKING_STATUS_BOOKED, $params);
        $this->_setExistingBookingId();
        if (!empty($this->getFkCustomer()) && !empty ($this->getFkBookingSlot()) && !empty($this->getIdBooking())) {
            $this->_buildInsertData(self::BOOKING_STATUS_CANCEL, $params);
            $result = $this->_bookingMapperModel->save($this);
        }
        return $result;
    }
    

}

