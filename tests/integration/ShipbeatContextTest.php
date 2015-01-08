<?php

class ShipbeatContextTest extends PHPUnit_Framework_TestCase
{
    private $shipbeatContext;
    private $token = 'LEiyY7NYj2JRN58C04RfKn6P3u1';
    private $mode = 'test';

    protected function setUp()
    {
        $this->shipbeatContext = new ShipbeatContext($this->token, $this->mode);
        parent::setUp();
    }

    public function testAreasAll()
    {
        $areas = $this->shipbeatContext->areas()->all();
        $this->assertEquals(200, $areas['code']);
    }

    public function testAreasAllWithParameters()
    {
        $params = array(
            'country' => 'DK',
            'q' => 'København',
            'sort' => 'code',
            'limit' => 5,
            'offset' => 2);
        $areas = $this->shipbeatContext->areas()->all($params);
        $this->assertEquals(200, $areas['code']);
        $this->assertEquals(5, sizeof($areas['response']));
        $this->assertArrayHasKey('total_count', $areas);
    }

    public function testAreasGet()
    {
        $areas = $this->shipbeatContext->areas()->get('eGp5QjMKkKITHcfyqIy7aB');
        $this->assertEquals(200, $areas['code']);
    }

    //    public function testAddressesPost()
//    {
//        $postFields = array(
//            'name1' => 'Mindaugas Bujanauskas',
//            'name2' => 'Shipbeat',
//            'street1' => 'Forbindelsesvej 12, 2. th',
//            'postal_code' => '2100',
//            'city' => 'København Ø',
//            'country_code' => 'DK'
//        );
//
//        $addresses = $this->shipbeatContext->addresses()->create($postFields);
//
//        $this->assertEquals(1, $addresses);
//    }

//    public function testAddresses()
//    {
//        $addresses = $this->shipbeatContext->addresses()->all();
//        $this->assertEquals(1, $addresses);
//    }

//    public function testItems()
//    {
//        $postFields = array(
//            'item_template' => 'size_s',
//            'value' => 179
//        );
//
////        $items = $this->shipbeatContext->items()->create($postFields);
//        $items = $this->shipbeatContext->items()->all();
//        $this->assertEquals(1, $items);
//    }

}
