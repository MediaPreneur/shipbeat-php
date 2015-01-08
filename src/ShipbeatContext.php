<?php

class ShipbeatContext
{
    private $addresses;
    private $items;
    private $areas;

    public function __construct($token, $mode, $domain = null)
    {
        if (is_null($domain))
            if ($mode == 'test')
                $domain = 'https://test.api.shipbeat.com';
            else
                $domain = 'https://api.shipbeat.com';

        $request = new Shipbeat_HttpCurlRequest($token, $mode, $domain);

        $this->areas = new Shipbeat_Areas($request);
        $this->addresses = new Shipbeat_Addresses($request);
        $this->items = new Shipbeat_Items($request);
    }

    public function areas()
    {
        return $this->areas;
    }

    public function addresses()
    {
        return $this->addresses;
    }

    public function items()
    {
        return $this->items;
    }
}
