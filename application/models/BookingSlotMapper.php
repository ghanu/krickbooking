<?php

class Application_Model_BookingSlotMapper
{

    protected $_dbTable;
    
    /**
     *
     * @param string $dbTable
     * @throws Exception
     * @return Application_Model_DbTable_Customer
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
            $this->setDbTable('Application_Model_DbTable_BookingSlot');
        }
        return $this->_dbTable;
    }
    
    /**
     *
     * @param string $slotHours
     */
    public function getBookingSlotIdBySlotHours($slotHours)
    {
        $where = sprintf("slot_hours = %s", $this->getDbTable()->getAdapter()->quote($slotHours));
        $result = $this->getDbTable()->fetchRow($where);
        return $result;
    }
}

