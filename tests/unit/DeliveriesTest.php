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
     * @var stdClass
     */
    private $expected;

    /**
     * Prepares test object before running tests
     */
    protected function setUp()
    {
        $this->expected = new stdClass();
        $this->expected->response = 'response';

        $request = $this->getMockBuilder('Shipbeat_Transport')
            ->setMethods(array('get', 'post'))
            ->setConstructorArgs(array('token', 'mode', 'domain'))
            ->getMock();

        $request->expects($this->any())
            ->method('get')
            ->will($this->returnValue($this->expected));

        $request->expects($this->any())
            ->method('post')
            ->will($this->returnValue($this->expected));

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
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }

    /**
     * Test create() method
     */
    public function testDeliveriesCreate()
    {
        $result = $this->deliveries->create();
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }
}
