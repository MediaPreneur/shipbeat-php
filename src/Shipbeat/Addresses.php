<?php

/**
 * Class Shipbeat_Addresses
 */
class Shipbeat_Addresses extends Shipbeat_Base
{
    /**
     * @param $request
     */
    function __construct($request)
    {
        parent::__construct($request);
        $this->endpoint = 'addresses';
    }

    function all($parameteres = null)
    {
        throw new Shipbeat_NotImplementedException(__METHOD__);
    }
}
