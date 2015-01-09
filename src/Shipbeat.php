<?php

/**
 * Class Shipbeat
 */
class Shipbeat
{
    /**
     * @var Shipbeat_Addresses
     */
    private $addresses;
    /**
     * @var Shipbeat_Items
     */
    private $items;
    /**
     * @var Shipbeat_Areas
     */
    private $areas;

    /**
     * @param $token
     * @param $mode
     * @param null $domain
     */
    public function __construct($token, $mode, $domain = null)
    {
        if (is_null($domain))
            if ($mode == 'test')
                $domain = 'https://test.api.shipbeat.com';
            else
                $domain = 'https://api.shipbeat.com';

        $request = new Shipbeat_Transport($token, $mode, $domain);

        $this->areas = new Shipbeat_Areas($request);
        $this->addresses = new Shipbeat_Addresses($request);
        $this->items = new Shipbeat_Items($request);
    }

    /**
     * @return Shipbeat_Areas
     */
    public function areas()
    {
        return $this->areas;
    }

    /**
     * @return Shipbeat_Addresses
     */
    public function addresses()
    {
        return $this->addresses;
    }

    /**
     * @return Shipbeat_Items
     */
    public function items()
    {
        return $this->items;
    }
}
