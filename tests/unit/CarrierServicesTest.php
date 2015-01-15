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
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }

}
