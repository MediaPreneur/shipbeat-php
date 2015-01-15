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
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }

    /**
     * Test get() method
     */
    public function testCarriersGet()
    {
        $result = $this->carriers->get('id');
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }

}
