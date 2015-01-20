![SHIPBEAT icon](https://static1.squarespace.com/static/52629d5fe4b04f55904b46d6/t/52bbfc8ce4b0a450b451aa45/1410803511760/)

#shipbeat-php

Shipbeat API wrapper for PHP


## Getting started

- If you are not familiar with Shipbeat, start with the [documentation](http://shipbeat.com/#benefits).
- Install the latest release.
- Check the API [reference](http://docs.shipbeat.com/).
- Check the examples.


## Installation

###Composer

If you don't already use Composer, then you probably should read the installation guide http://getcomposer.org/download/.

Please include this library via Composer in your composer.json and execute composer update to refresh the autoload.php.

```json
{
"repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/shipbeat/shipbeat-php"
    }
  ],
  "require": {
    "shipbeat/shipbeat-php" : "dev-master"
  }
}
```

To load the Shipbeat library from your project's root folder you need to require Shipbeat's autoload script like this:
```php
require_once __DIR__ . '/vendor/autoload.php';
```


###No Composer

If you don't want to use Composer, just download the library in your project via Web or following command line:

`git clone https://github.com/shipbeat/shipbeat-php.git`


To load the Shipbeat library from your project's root folder you need to require Shipbeat's bootstrap script like this:

```php
require_once('pathToShipbeat/bootstrap.php');
```

##Examples

### Getting delivery quote

```php
// Set your authentication data
$authData = //"Your Shipbeat API token or array('username' => Your username,
//    'password' => Your password)";

// Set mode to test while in development
$mode = 'test';

// Create a Shipbeat API instance with mode and authorization data
$shipbeat = new Shipbeat($authData, $mode);

// Create an item that will be delivered
$itemsParams = array(
    'item_template' => 'size_s',
    'value' => 179
);
$items = $shipbeat->items()->create($itemsParams);

// Create a pick up address that the carrier will take the item from 
$AddressesParamsFrom = array(
    'name1' => 'From',
    'name2' => 'Shipbeat',
    'street1' => 'From street',
    'postal_code' => '2100',
    'city' => 'København Ø',
    'country_code' => 'DK'
);
$addressesFrom = $shipbeat->addresses()->create($AddressesParamsFrom);

// Create a delivery address that the carrier will deliver the item to
$AddressesParamsTo = array(
    'name1' => 'To',
    'name2' => 'Shipbeat',
    'street1' => 'To street',
    'postal_code' => '2100',
    'city' => 'København Ø',
    'country_code' => 'DK'
);
$addressesTo = $shipbeat->addresses()->create($AddressesParamsTo);

// Create available delivery quotes
$quotesParams = array('delivery_option' => 'standard_delivery',
    'item' => $items->id, 'from' => $addressesFrom->id, 'to' => $addressesTo->id);
$quotes = $shipbeat->quotes()->create($quotesParams);
```

### Accepting a quote (creating a delivery)

```php
// Create a delivery with the first quote from the available delivery quotes
$deliveriesParams = array('quote' => $quotes->data[0]->id);
$delivery = $shipbeat->deliveries()->create($deliveriesParams);
```

### Getting a label for accepted quote

```php
// Getting all labels for a delivery
$label = $shipbeat->labels()->get($delivery->label_id);
```

