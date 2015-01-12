<?php

/**
 * Shipbeat_CarrierServices test cases
 */
class Shipbeat_CarrierServicesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat_CarrierServices
     */
    private $carrierServices;

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

        $this->carrierServices = new Shipbeat_CarrierServices($request);
        parent::setUp();
    }

    /**
     * Cleans test object after running tests
     */
    protected function tearDown()
    {
        $this->carrierServices = null;
        parent::tearDown();
    }

    /**
     * Test get() method
     */
    public function testCarrierServicesGet()
    {
        $result = $this->carrierServices->get('id');
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }

}
