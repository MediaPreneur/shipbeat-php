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
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }

    /**
     * Test create() method
     */
    public function testItemsCreate()
    {
        $result = $this->items->create();
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }
}
