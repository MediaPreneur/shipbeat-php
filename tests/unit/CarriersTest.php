<?php

/**
 * Shipbeat_Carriers test cases
 */
class Shipbeat_CarriersTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat_Carriers
     */
    private $carriers;

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

        $this->carriers = new Shipbeat_Carriers($request);
        parent::setUp();
    }

    /**
     * Cleans test object after running tests
     */
    protected function tearDown()
    {
        $this->carriers = null;
        parent::tearDown();
    }

    /**
     * Test all() method
     */
    public function testCarriersAll()
    {
        $result = $this->carriers->all();
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }

    /**
     * Test get() method
     */
    public function testCarriersGet()
    {
        $result = $this->carriers->get('id');
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }

}
