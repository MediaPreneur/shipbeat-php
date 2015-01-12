<?php

/**
 * Class Shipbeat_CarrierServices
 */
class Shipbeat_CarrierServices extends Shipbeat_Base
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
        $this->endpoint = 'carriers/services';
    }

    function all($parameteres = null)
    {
        throw new Exception('Not implemented');
    }

    function create($parameteres = null)
    {
        throw new Exception('Not implemented');
    }
}
