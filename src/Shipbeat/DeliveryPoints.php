<?php

/**
 * Class Shipbeat_DeliveryPoints
 */
class Shipbeat_DeliveryPoints extends Shipbeat_Base
{
    /**
     * @param $request
     */
    function __construct($request)
    {
        parent::__construct($request);
        $this->endpoint = 'delivery_points';
    }

    function create($parameteres = null)
    {
        throw new Shipbeat_NotImplementedException(__METHOD__);
    }
}
