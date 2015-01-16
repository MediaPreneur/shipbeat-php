<?php

/**
 * Class Shipbeat integration tests
 */
class ShipbeatNegativeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat
     */
    private $shipbeat;

    /**
     * @var string or array
     */
    private $authData = array('username' => 'wrong username',
    'password' => 'wrong password');

    /**
     * @var string
     */
    private $mode = 'test';

    /**
     * @expectedException Shipbeat_Exception_APIError
     */
    public function testLoginWithWrongCredentials()
    {
        $this->shipbeat = new Shipbeat($this->authData, $this->mode);
    }
}
