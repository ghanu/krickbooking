<?php
/**
 * 
 * @author ghanu
 *
 */
class StadiumEditBookingTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    protected $_stadiumBookingModel;
    protected $_bookingModel;
    
    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
        $this->_stadiumBookingModel = new Application_Model_StadiumEditBooking();
        
        //make mock builder to mock booking
        $this->_bookingModel = $this->getMockBuilder('Application_Model_EditBooking')
            ->disableOriginalConstructor()
            ->getMock();
        $this->_stadiumBookingModel->setBookingModel($this->_bookingModel);
    }

     public function testCreatingBookingWithValidParams()
     {
         //arrange
         $params = $this->_getValidParams();
         $this->_bookingModel->expects($this->any())->method('editBooking')
             ->willReturn('1');
        
         //act
         $result = $this->_stadiumBookingModel->editBooking($params);

         //assert
         $this->assertEquals('success', $result['status']);
      }
       
       public function testCreatingBookingWithInvalidParams()
       {
           //arrange
           $params = $this->_getInvalidParams();
       
           //act
           $result = $this->_stadiumBookingModel->editBooking($params);

           //assert
           $this->assertEquals('failed', $result['status']);
       }
       
       public function testCreatingBookingWithInvalidDate()
       {
           //arrange
           $params = $this->_getInvalidDate();
            
           //act
           $result = $this->_stadiumBookingModel->editBooking($params);
       
           //assert
           $this->assertEquals('failed', $result['status']);
       }
       

       /**
        * 
        * @return array
        */
       protected function _getValidParams()
       {
           return array(
               'email' => 'khanraj.2k5@gmail.com',
               'booking_date' => '2016-02-20',
               'booking_slot' => '5-6',
               'old_booking_date' => '2016-02-20',
               'booking_slot' => '6-7'
            );
       }
       
       /**
        * 
        * @return array
        */
       protected function _getInvalidParams()
       {
           return array(
               'email_address' => 'khanraj.2k5@gmail.com',
               'booking_date' => '2016-02-20',
               'booking_slot' => '5-6'
           );
       }
       
       protected function _getInvalidDate()
       {
           return array(
               'email' => 'khanraj.2k5@gmail.com',
               'booking_date' => '2016-02-20',
               'booking_slot' => '5-6',
               'old_booking_date' => '2016-02-20',
               'booking_slot' => '6-7'
           );
       }

}

