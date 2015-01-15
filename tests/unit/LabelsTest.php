<?php

/**
 * Shipbeat_Labels test cases
 */
class Shipbeat_LabelsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat_Labels
     */
    private $labels;

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

        $this->labels = new Shipbeat_Labels($request);
        parent::setUp();
    }

    /**
     * Cleans test object after running tests
     */
    protected function tearDown()
    {
        $this->labels = null;
        parent::tearDown();
    }

    /**
     * Test get() method
     */
    public function testGet()
    {
        $result = $this->labels->get('id');
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }

    /**
     * Test create() method
     */
    public function testGetLabelForItem()
    {
        $result = $this->labels->getLabelForItem('id', 'item');
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }
}
