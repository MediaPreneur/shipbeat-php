<?php

/**
 * Class Shipbeat integration tests
 */
class ShipbeatTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Shipbeat
     */
    private $shipbeat;
    /**
     * @var string
     */
    private $token = 'LEiyY7NYj2JRN58C04RfKn6P3u1';
    /**
     * @var string
     */
    private $mode = 'test';

    /**
     * Prepares test object before running tests
     */
    protected function setUp()
    {
        $this->shipbeat = new Shipbeat($this->token, $this->mode);
        parent::setUp();
    }

    /**
     * Cleans test object after running tests
     */
    public function testAreasAll()
    {
        $areas = $this->shipbeat->areas()->all();
        $this->assertEquals(200, $areas['code']);
    }

    /**
     * Test Areas all() method
     */
    public function testAreasAllWithParameters()
    {
        $params = array(
            'country' => 'DK',
            'q' => 'København',
            'sort' => 'code',
            'limit' => 5,
            'offset' => 2);
        $areas = $this->shipbeat->areas()->all($params);
        $this->assertEquals(200, $areas['code']);
        $this->assertEquals(5, sizeof($areas['response']));
        $this->assertArrayHasKey('total_count', $areas);
    }

    /**
     * Test Areas get() method
     */
    public function testAreasGet()
    {
        $areas = $this->shipbeat->areas()->get('eGp5QjMKkKITHcfyqIy7aB');
        $this->assertEquals(200, $areas['code']);
    }

    /**
     * Test Addresses create() and get() methods
     */
    public function testAddressesPostAndGet()
    {
        $params = array(
            'name1' => 'Mindaugas Bujanauskas',
            'name2' => 'Shipbeat',
            'street1' => 'Forbindelsesvej 12, 2. th',
            'postal_code' => '2100',
            'city' => 'København Ø',
            'country_code' => 'DK'
        );

        $addresses = $this->shipbeat->addresses()->create($params);
        $this->assertEquals(200, $addresses['code']);

        $address = $this->shipbeat->addresses()->get($addresses['response']->id);
        $this->assertEquals(200, $address['code']);
    }

    /**
     * Test Items create() and get() methods
     */
    public function testItems()
    {
        $params = array(
            'item_template' => 'size_s',
            'value' => 179
        );

        $items = $this->shipbeat->items()->create($params);
        $this->assertEquals(200, $items['code']);

        $item = $this->shipbeat->items()->get($items['response']->id);
        $this->assertEquals(200, $item['code']);
    }

}
