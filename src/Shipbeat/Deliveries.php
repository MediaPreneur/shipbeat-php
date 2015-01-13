<?php

/**
 * Class Shipbeat_Deliveries
 */
class Shipbeat_Deliveries extends Shipbeat_Base
{
    /**
     * @param $request
     */
    function __construct($request)
    {
        parent::__construct($request);
        $this->endpoint = 'deliveries';
    }

    function all($parameteres = null)
    {
        throw new Shipbeat_NotImplementedException(__METHOD__);
    }
}
