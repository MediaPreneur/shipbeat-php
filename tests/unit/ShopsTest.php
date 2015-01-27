<?php

/**
 * Shipbeat_Shops test cases
 */
class Shipbeat_ShopsTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Shipbeat_Shops
	 */
	private $shops;

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

		$this->shops = new Shipbeat_Shops($request);
		parent::setUp();
	}

	/**
	 * Cleans test object after running tests
	 */
	protected function tearDown()
	{
		$this->shops = null;
		parent::tearDown();
	}

	/**
	 * Test get() method
	 */
	public function testShopsGet()
	{
		$result = $this->shops->get('id');
		$this->assertInstanceOf('stdClass', $result);
		$this->assertEquals($this->expected->response, $result->response);
	}

	/**
	 * Test all() method
	 */
	public function testShopsAll()
	{
		$result = $this->shops->all();
		$this->assertInstanceOf('stdClass', $result);
		$this->assertEquals($this->expected->response, $result->response);
	}
}
