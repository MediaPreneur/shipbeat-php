<?php

/**
 * Shipbeat_Items test cases
 */
class Shipbeat_ItemsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat_Items
     */
    private $items;

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

        $this->items = new Shipbeat_Items($request);
        parent::setUp();
    }

    /**
     * Cleans test object after running tests
     */
    protected function tearDown()
    {
        $this->items = null;
        parent::tearDown();
    }

    /**
     * Test get() method
     */
    public function testItemsGet()
    {
        $result = $this->items->get('id');
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }

    /**
     * Test create() method
     */
    public function testItemsCreate()
    {
        $result = $this->items->create();
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }
}
