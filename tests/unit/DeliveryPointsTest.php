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
     * Prepares test object before running tests
     */
    protected function setUp()
    {
        $result = array('code' => 200, 'response' => 'body');

        $request = $this->getMockBuilder('Shipbeat_Transport')
            ->setMethods(array('get'))
            ->setConstructorArgs(array('token', 'mode', 'domain'))
            ->getMock();

        $request->expects($this->any())
            ->method('get')
            ->will($this->returnValue($result));

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
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }

    /**
     * Test get() method
     */
    public function testDeliveryPointsGet()
    {
        $result = $this->deliveryPoints->get('id');
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }

}
