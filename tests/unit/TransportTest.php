<?php

/**
 * Shipbeat_Transport test cases
 */
class Shipbeat_TransportTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat_Transport
     */
    private $transport;

    /**
     * Prepares test object before running tests
     */
    protected function setUp()
    {
        $this->transport = $this->getMockBuilder('Shipbeat_Transport')
            ->setMethods(array('curl_exec', 'curl_getinfo'))
            ->setConstructorArgs(array('token', 'mode', 'domain'))
            ->getMock();

        $this->transport->expects($this->any())
            ->method('curl_exec')
            ->will($this->returnValue('response'));

        $this->transport->expects($this->any())
            ->method('curl_getinfo')
            ->will($this->returnValue(200));

        parent::setUp();
    }

    /**
     * Cleans test object after running tests
     */
    protected function tearDown()
    {
        $this->transport = null;
        parent::tearDown();
    }

    /**
     * Test get() method
     */
    public function testGet()
    {
        $result = $this->transport->get('');
        $this->assertEquals(200, $result['code']);
    }

    /**
     * Test post() method
     */
    public function testPost()
    {
        $result = $this->transport->post('');
        $this->assertEquals(200, $result['code']);
    }
}
