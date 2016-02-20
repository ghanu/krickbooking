<?php

class Application_Model_BookingstatusMapper
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
            $this->setDbTable('Application_Model_DbTable_Bookingstatus');
        }
        return $this->_dbTable;
    }
    
    /**
     *
     * @param string $statusName
     */
    public function getBookingStatusByStatusName($statusName)
    {
        $where = sprintf("name = %s", $this->getDbTable()->getAdapter()->quote($statusName));
        $result = $this->getDbTable()->fetchRow($where);
        return $result;
    }

}

