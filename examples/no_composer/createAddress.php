<?php

require_once __DIR__ . '/../../bootstrap.php';

$token = 'LEiyY7NYj2JRN58C04RfKn6P3u1';
$mode = 'test';

$postFields = array(
    'name1' => 'Mindaugas Bujanauskas',
    'name2' => 'Shipbeat',
    'street1' => 'Forbindelsesvej 12, 2. th',
    'postal_code' => '2100',
    'city' => 'København Ø',
    'country_code' => 'DK',
);

$shipbeatContext = new ShipbeatContext($token, $mode);
$addresses = $shipbeatContext->addresses()->create($postFields);

var_dump($addresses);

