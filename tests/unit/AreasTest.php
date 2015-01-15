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
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }

    /**
     * Test get() method
     */
    public function testAreasGet()
    {
        $result = $this->areas->get('id');
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }

}
