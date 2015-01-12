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
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }

    /**
     * Test create() method
     */
    public function testQuotesCreate()
    {
        $result = $this->quotes->create();
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }
}
