<?php

/**
 * Shipbeat_Addresses test cases
 */
class Shipbeat_AddressesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat_Addresses
     */
    private $addresses;

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

        $this->addresses = new Shipbeat_Addresses($request);
        parent::setUp();
    }

    /**
     * Cleans test object after running tests
     */
    protected function tearDown()
    {
        $this->addresses = null;
        parent::tearDown();
    }

    /**
     * Test get() method
     */
    public function testAddressesGet()
    {
        $result = $this->addresses->get('id');
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }

    /**
     * Test create() method
     */
    public function testAddressesCreate()
    {
        $result = $this->addresses->create();
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }
}
