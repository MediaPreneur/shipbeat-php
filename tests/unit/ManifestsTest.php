<?php

/**
 * Shipbeat_Manifests test cases
 */
class Shipbeat_ManifestsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat_Manifests
     */
    private $manifests;

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

        $this->manifests = new Shipbeat_Manifests($request);
        parent::setUp();
    }

    /**
     * Cleans test object after running tests
     */
    protected function tearDown()
    {
        $this->manifests = null;
        parent::tearDown();
    }

    /**
     * Test get() method
     */
    public function testManifestsGet()
    {
        $result = $this->manifests->get('id');
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('body', $result['response']);
    }

}
