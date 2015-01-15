<?php

/**
 * Shipbeat_Quotes test cases
 */
class Shipbeat_QuotesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat_Quotes
     */
    private $quotes;

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

        $this->quotes = new Shipbeat_Quotes($request);
        parent::setUp();
    }

    /**
     * Cleans test object after running tests
     */
    protected function tearDown()
    {
        $this->quotes = null;
        parent::tearDown();
    }

    /**
     * Test get() method
     */
    public function testQuotesGet()
    {
        $result = $this->quotes->get('id');
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }

    /**
     * Test create() method
     */
    public function testQuotesCreate()
    {
        $result = $this->quotes->create();
        $this->assertInstanceOf('stdClass', $result);
        $this->assertEquals($this->expected->response, $result->response);
    }
}
