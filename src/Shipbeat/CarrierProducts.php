<?php

/**
 * Class Shipbeat_CarrierProducts
 */
class Shipbeat_CarrierProducts extends Shipbeat_Base
{
    /**
     * @var Shipbeat_Transport
     */
    protected $request;

    /**
     * @param $request
     */
    function __construct($request)
    {
        parent::__construct($request);
        $this->endpoint = 'carriers/products';
    }

    function all($parameteres = null)
    {
        throw new Shipbeat_NotImplementedException(__METHOD__);
    }

    function create($parameteres = null)
    {
        throw new Shipbeat_NotImplementedException(__METHOD__);
    }
}
