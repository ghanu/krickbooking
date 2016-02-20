<?php
/**
 * 
 * @author Ghanu <khanraj.2k5@gmail.com>
 *
 */
class Application_Model_BookingMapper
{
    protected $_dbTable;
    
    /**
     *
     * @param string $dbTable
     * @throws Exception
     * @return Application_Model_Booking
     */
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    
    /**
     *
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Booking');
        }
        return $this->_dbTable;
    }
    
    /**
     * 
     * @param Application_Model_Booking $booking
     */
    public function save(Application_Model_Booking $booking)
    {
        $data = array(
            'fk_customer' => $booking->getFkCustomer(),
            'fk_booking_slot' => $booking->getFkBookingSlot(),
            'fk_booking_status' => $booking->getFkBookingStatus(),
            'booking_date' =>  $booking->getBookingDate(),
            'created_at' => date('Y-m-d H:i:s'),
        );
    
        if (null === ($id = $booking->getIdBooking())) {
            unset($data['id_booking']);
            $result = $this->getDbTable()->insert($data);
        } else {
            $result = $this->getDbTable()->update($data, array('id_booking = ?' => $id));
        }
        return $result;
    }
    
    /**
     *
     * @param Application_Model_Booking $booking
     * @return boolean
     */
    public function toCheckDuplicateBookingRow(Application_Model_Booking $booking)
    {
        $result = $this->getExistingBookingRow($booking);
        if (empty($result)) {
            return true;
        }
        return false;
    }
    
    /**
     *
     * @param Application_Model_Booking $booking
     * @return boolean
     */
    public function getExistingBookingRow($booking) 
    {
        $dbAdapter = $this->getDbTable()->getAdapter();
        $where = sprintf(
            "fk_customer = %s AND booking_date = %s AND fk_booking_status = %s",
            $dbAdapter->quote($booking->getFkCustomer()),
            $dbAdapter->quote($booking->getBookingDate()),
            $dbAdapter->quote($booking->getFkBookingStatus())
        );
        $result = $this->getDbTable()->fetchRow($where);
        return $result;
    }
}

