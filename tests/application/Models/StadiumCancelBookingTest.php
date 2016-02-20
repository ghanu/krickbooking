<?php
/**
 * 
 * @author ghanu
 *
 */
class StadiumCancelBookingTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    protected $_stadiumBookingModel;
    protected $_bookingModel;
    
    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
        $this->_stadiumBookingModel = new Application_Model_StadiumCancelBooking();
        
        //make mock builder to mock booking
        $this->_bookingModel = $this->getMockBuilder('Application_Model_CancelBooking')
            ->disableOriginalConstructor()
            ->getMock();
        $this->_stadiumBookingModel->setBookingModel($this->_bookingModel);
    }

     public function testCreatingBookingWithValidParams()
     {
         //arrange
         $params = $this->_getValidParams();
         $this->_bookingModel->expects($this->any())->method('cancelBooking')
             ->willReturn('1');
        
         //act
         $result = $this->_stadiumBookingModel->cancelBooking($params);

         //assert
         $this->assertEquals('success', $result['status']);
      }
       
       public function testCreatingBookingWithInvalidDate()
       {
           //arrange
           $params = $this->_getInvalidDateParams();
       
           //act
           $result = $this->_stadiumBookingModel->cancelBooking($params);

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
                'booking_slot' => '5-6'
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
       /**
        *
        * @return array
        */
       protected function _getInvalidDateParams()
       {
           return array(
               'email_address' => 'khanraj.2k5@gmail.com',
               'booking_date' => '2016-02-31',
               'booking_slot' => '5-6'
           );
       }

}

