shipwire-api
============
These library will help you with the usage of Shipwire API.

To use it you only have to configure your username and password in your config-local file like this:

```php
<?php 
return ['username'=>'youruser@email.com', 'password'=>'YOURUSERPASSWORD'];
```


### Installing via Composer

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
### Documentation