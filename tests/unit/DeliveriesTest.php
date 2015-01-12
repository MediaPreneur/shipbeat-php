<?php

/**
 * Shipbeat_Deliveries test cases
 */
class Shipbeat_DeliveriesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat_Deliveries
     */
    private $deliveries;

    /**
     * Prepares test object before running tests
     */
    protected function setUp()
    {
        $result = array('code' => 200, 'response' => 'body');

        $request = $this->getMockBuilder('Shipbeat_Transport')
            ->setMethods(array('get', 'post'))
            ->setConstructorArgs(array('token', 'mode', 'domain'))
            ->getMock();

        $request->expects($this->any())
            ->method('get')
            ->will($this->returnValue($result));

        $request->expects($this->any())
            ->method('post')
            ->will($this->returnValue($result));

        $this->deliveries = new Shipbeat_Deliveries($request);
        parent::setUp();
    }

    /**
     * Cleans test object after running tests
     */
    protected function tearDown()
    {
        $this->deliveries = null;
        parent::tearDown();
    }

    /**
     * Test get() method
     */
    public function testDeliveriesGet()
    {
        $result = $this->deliveries->get('id');
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }

    /**
     * Test create() method
     */
    public function testDeliveriesCreate()
    {
        $result = $this->deliveries->create();
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }
}
