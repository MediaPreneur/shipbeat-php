<?php

/**
 * Class Shipbeat_Items
 */
class Shipbeat_Items extends Shipbeat_Base
{
    /**
     * @param $request
     */
    function __construct($request)
    {
        parent::__construct($request);
        $this->endpoint = 'items';
    }

    function all($parameteres = null)
    {
        throw new Shipbeat_NotImplementedException(__METHOD__);
    }
}
