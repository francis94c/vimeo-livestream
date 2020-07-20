# vimeo-livestream
PHP Client Library for Vimeo Live Stream.

<p style="text-align:center;"><img width="200" src="https://livestream.com/assets/images/shared/livestream_og_image.jpg"/></p>

## Installation ##
This Live Stream API is available on Packagist as francis94c/vimeo-livestream

```php
$ composer require francis94c/vimeo-livestream
```

## Usage ##
__Note that `$livestream` function calls that return null, indicates that the requested resource was not found. In summary, a 404 HTTP Response Code was received as a result of the call. Every other HTTP Response Code will throw an Exception.__

```php
use LiveStream\LiveStream;

use LiveStream\Resources\Event;

$livestream = new LiveStream('[YOUR_API_KEY]');

// Get Accounts
$accounts = $livestream->getAccounts(); // Returns an array of account resources.

// Get Specific Account
$account = $livestream->getAccount(23456 /*Account ID*/); // Returns \LiveStream\Resources\Account.

// Create Event
$event = new Event("A Career Master Class" /*fullName*/);
// See https://livestream.com/developers/docs/api/#event-object
$event->setShortName("Master Class"); /*Or*/ $event->shortName = 'Master Class';
$event->setStartTime("2020-07-20 23:56:20"); /*Or*/ $event->startTime = /*Time in ISO8601 date time format*/

// Get RTMPKey
$key = $livestream->getRtmpKey(3456 /*Account ID*/, 4567, /*Event ID*/);
echo $key->id . ' --- ' . $key->rtmpUrl;
// OR
echo $key->getId() . ' --- ' . $key->getRtmpUrl();

// Reset RTMPKey
$key = $livestream->resetRtmpKey(3456 /*Account ID*/, 4567, /*Event ID*/);
```