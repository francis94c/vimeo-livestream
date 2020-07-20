# vimeo-livestream
PHP Client Library for Vimeo Live Stream.

<p style="text-align:center;"><img width="200" src="https://livestream.com/assets/images/shared/livestream_og_image.jpg"/></p>

## Installation ##
This Live Stream API is available on Packagist as francis94c/vimeo-livestream

```php
$ composer require francis94c/vimeo-livestream
```

## Usage ##
```php
use LiveStream\LiveStream;

$livestream = new LiveStream('[YOUR_API_KEY]');

// Get Accounts
$accounts = $livestream->getAccounts(); // Returns an array of account resources.

// Get Specific Account
$account = $livestream->getAccount(23456 /*Acount ID*/); // Returns \LiveStream\Resources\Account.
```