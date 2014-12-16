shipwire-api
============
These library will help you with the usage of Shipwire API.

## Installing via Composer

The recommended way to install Guzzle is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of Guzzle:

```bash
composer require flydreamers/shipwire
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

## Documentation

### Initial configuration

To configure the library just call ShipwireConnector::init() function to and start using it.

To use it you only have to configure your username and password in The clientyour config-local file like this:

```php
ShipwireConnector::init($config['username'], $config['password'], 'sandbox');
```

### Stock

To check for Stock of a product:

```php
$response = $stock->getStockBySKUs(['CAPTRACKERBLUE']);
```

If you have more than one SKU, just add them to the array like:

```php
$response = $stock->getStockBySKUs(['CAPTRACKERBLUE', 'CAPTRACKERRED', 'ETCETERA']);
```
Extra parameters can be used. See \flydreamers\shipwire\Stock for more information.

### Rates

You can ask Shipwire API for a shipping rate using Rate class.


```php
$rate = new Rate;
$options = [
    "currency" => "USD",
    "groupBy" => "all",
    "canSplit" => 1,
    "warehouseArea" => "US"
];

$address = Address::createFromArray([
    "address1" => "6501 Railroad Avenue SE",
    "address2" => "Room 315",
    "address3" => "",
    "city" => "Snoqualmie",
    "postalCode" => "85283",
    "region" => "WA",
    "country" => "US",
    "isCommercial" => 0,
    "isPoBox" => 0
]);

$items = [
    ['sku' => 'CAPTRACKERBLUE', 'quantity' => 3]
];

$shippingInfo = $rate->quote($address, $items, $config);
```