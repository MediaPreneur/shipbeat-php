<?php

/**
 * Shipbeat_DeliveryPoints test cases
 */
class Shipbeat_DeliveryPointsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat_DeliveryPoints
     */
    private $deliveryPoints;

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
            ->setMethods(array('get'))
            ->setConstructorArgs(array('token', 'mode', 'domain'))
            ->getMock();

        $request->expects($this->any())
            ->method('get')
            ->will($this->returnValue($this->expected));

        $this->deliveryPoints = new Shipbeat_DeliveryPoints($request);
        parent::setUp();
    }

    /**
     * Cleans test object after running tests
     */
    protected function tearDown()
    {
        $this->deliveryPoints = null;
        parent::tearDown();
    }

    /**
     * Test all() method
     */
    public function testDeliveryPointsAll()
    {
        $result = $this->deliveryPoints->all();
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }

    /**
     * Test get() method
     */
    public function testDeliveryPointsGet()
    {
        $result = $this->deliveryPoints->get('id');
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }

}
