<?php

/**
 * Class Shipbeat
 */
class Shipbeat
{
    /**
     * @var Shipbeat_Items
     */
    private $items;

    /**
     * @var Shipbeat_Areas
     */
    private $areas;

    /**
     * @var Shipbeat_DeliveryPoints
     */
    private $deliveryPoints;

    /**
     * @var Shipbeat_Addresses
     */
    private $addresses;

    /**
     * @var Shipbeat_Quotes
     */
    private $quotes;

    /**
     * @var Shipbeat_Deliveries
     */
    private $deliveries;

    /**
     * @var Shipbeat_Manifests
     */
    private $manifests;

    /**
     * @var Shipbeat_Carriers
     */
    private $carriers;

    /**
     * @var Shipbeat_CarrierServices
     */
    private $carrierServices;

    /**
     * @var Shipbeat_CarrierProducts
     */
    private $carrierProducts;

    /**
     * @param $token
     * @param $mode
     * @param null $domain
     */
    public function __construct($token, $mode = null, $domain = null)
    {
        if (is_null($domain))
            if ($mode == 'test')
                $domain = 'https://test.api.shipbeat.com';
            else {
                $mode = 'live';
                $domain = 'https://api.shipbeat.com';
            }

        $request = new Shipbeat_Transport($token, $mode, $domain);

        $this->items = new Shipbeat_Items($request);
        $this->areas = new Shipbeat_Areas($request);
        $this->deliveryPoints = new Shipbeat_DeliveryPoints($request);
        $this->addresses = new Shipbeat_Addresses($request);
        $this->quotes = new Shipbeat_Quotes($request);
        $this->deliveries = new Shipbeat_Deliveries($request);

        $this->manifests = new Shipbeat_Manifests($request);
        $this->carriers = new Shipbeat_Carriers($request);
        $this->carrierServices = new Shipbeat_CarrierServices($request);
        $this->carrierProducts = new Shipbeat_CarrierProducts($request);
    }

    /**
     * @return Shipbeat_Items
     */
    public function items()
    {
        return $this->items;
    }

    /**
     * @return Shipbeat_Areas
     */
    public function areas()
    {
        return $this->areas;
    }

    /**
     * @return Shipbeat_DeliveryPoints
     */
    public function deliveryPoints()
    {
        return $this->deliveryPoints;
    }

    /**
     * @return Shipbeat_Addresses
     */
    public function addresses()
    {
        return $this->addresses;
    }

    /**
     * @return Shipbeat_Quotes
     */
    public function quotes()
    {
        return $this->quotes;
    }

    /**
     * @return Shipbeat_Deliveries
     */
    public function deliveries()
    {
        return $this->deliveries;
    }

    /**
     * @return Shipbeat_Manifests
     */
    public function manifests()
    {
        return $this->manifests;
    }

    /**
     * @return Shipbeat_Carriers
     */
    public function carriers()
    {
        return $this->carriers;
    }

    /**
     * @return Shipbeat_CarrierServices
     */
    public function carrierServices()
    {
        return $this->carrierServices;
    }

    /**
     * @return Shipbeat_CarrierProducts
     */
    public function carrierProducts()
    {
        return $this->carrierProducts;
    }
}
