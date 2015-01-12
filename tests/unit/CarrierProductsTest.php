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
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }

}
