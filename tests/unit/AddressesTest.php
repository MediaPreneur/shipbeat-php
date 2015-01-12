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
     * Prepares test object before running tests
     */
    protected function setUp()
    {
        $result = array('code' => 200, 'response' => 'body');

        $request = $this->getMockBuilder('Shipbeat_Transport')
            ->setMethods(array('get', 'post'))
            ->setConstructorArgs(array('token', 'mode', 'domain'))
            ->getMock();

        $request->expects($this->any())
            ->method('get')
            ->will($this->returnValue($result));

        $request->expects($this->any())
            ->method('post')
            ->will($this->returnValue($result));

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
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }

    /**
     * Test create() method
     */
    public function testAddressesCreate()
    {
        $result = $this->addresses->create();
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }
}
