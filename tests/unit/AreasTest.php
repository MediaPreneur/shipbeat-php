<?php

/**
 * Shipbeat_Areas test cases
 */
class Shipbeat_AreasTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat_Areas
     */
    private $areas;

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

        $this->areas = new Shipbeat_Areas($request);
        parent::setUp();
    }

    /**
     * Cleans test object after running tests
     */
    protected function tearDown()
    {
        $this->areas = null;
        parent::tearDown();
    }

    /**
     * Test all() method
     */
    public function testAreasAll()
    {
        $result = $this->areas->all();
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }

    /**
     * Test get() method
     */
    public function testAreasGet()
    {
        $result = $this->areas->get('id');
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }

}
