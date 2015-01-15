<?php

/**
 * Shipbeat_CarrierProducts test cases
 */
class Shipbeat_CarrierProductsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat_CarrierProducts
     */
    private $carrierProducts;

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

        $this->carrierProducts = new Shipbeat_CarrierProducts($request);
        parent::setUp();
    }

    /**
     * Cleans test object after running tests
     */
    protected function tearDown()
    {
        $this->carrierProducts = null;
        parent::tearDown();
    }

    /**
     * Test get() method
     */
    public function testCarrierProductsGet()
    {
        $result = $this->carrierProducts->get('id');
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }

}
