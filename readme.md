# VimeoConnector

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

**Helper class to connect to Vimeo and download video information based on video ID or URL**

This package provides a class with connection and helper functionality to allow gathering video
information if you have the URL or ID. Made this just 'cause all those others out there were not
to my particular liking.



## Installation


### Dependencies

This package was tested with
* PHP 7.3+ with ext-curl
* Laravel 8.0 (optional, but package includes an AddonServiceProvider for this)


### Installation

Via Composer
```bash
composer require eleven59/vimeo-connector
```

Then add Vimeo key and secret to your .env file and you're good to go:
```dotenv
VIMEO_KEY="vimeo key"
VIMEO_SECRET="vimeo secret"
```


## Connector functions

This package includes a single static class that will help you connect to Vimeo and get all the
info you need if you have a Video Id. Does not (yet) work for events. If you only have an Url,
see Helper functions below. Isn't that convenient?

### Get all info as returned by Vimeo
See [Vimeo Video API reference][link-video]
```php
use Eleven59\VimeoConnector\Models\VimeoConnector;
$video = VimeoConnector::getInfo($vimeoId);
```

### Get all stills for a video
Instead of processing all that info yourself every time, why not use the built-in complementary
function for that?
```php
use Eleven59\VimeoConnector\Models\VimeoConnector;
$stills = VimeoConnector::getStills($vimeoId);
```

### Get only the cover for the video
Now, why would you process all of those images yourself if you only want the biggest, baddest
image on the block? This one returns the still that matches both the width and height of the
video. It's probably the biggest and the best match. I know that's not always the best option,
but it's a great approximation and there's always the function above if you need more nuance.
```php
use Eleven59\VimeoConnector\Models\VimeoConnector;
$stills = VimeoConnector::getCover($vimeoId);
```




## Helper functions
You can convert URLs to IDs for both events and videos. Isn't that great?


### URL to ID
There are two ways to go about this. You can use the know-it-all function that will just give you
an ID no matter if you use a video or event URL. If you need to validate that the link is either
a video *or* an event, you are very welcome to try the separate functions instead.

```php
use Eleven59\VimeoConnector\Models\VimeoHelper;
$id = VimeoHelper::getIdFromUrl($url); // returns event or video Id or false
$eventId = VimeoHelper::getEventIdFromUrl($url); // returns event Id or false
$videoId = VimeoHelper::getVideoIdFromUrl($url); // returns video Id or false
```


### ID to (Embed) URL
If you have either an Id or a full-fledged URL or even an embed code, these functions can
translate any of those into either a Video URL or Ember URL, no questions asked.

```php
use Eleven59\VimeoConnector\Models\VimeoHelper;
$embedUrl = VimeoHelper::getEmbedUrl($urlOrId); // works for events and videos (returns event url if numeric input is given)
$eventEmbedUrl = VimeoHelper::getEventEmbedUrl($urlOrId); // works only for events
$videoEmbedUrl = VimeoHelper::getVideoEmbedUrl($urlOrId); // works only for videos
```

## Change log

Breaking changes will be listed here. For other changes see commit log.



## Credits

- [Nik Linders @ eleven59.nl][link-author]



## License

This project was released under the MIT license, so you can install it on top of any Backpack & Laravel project. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/eleven59/vimeo-connector.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/eleven59/vimeo-connector.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/eleven59/vimeo-connector
[link-downloads]: https://packagist.org/packages/eleven59/vimeo-connector
[link-author]: https://github.com/eleven59
[link-video]: https://developer.vimeo.com/api/reference/responses/video
[link-intervention-image]: https://github.com/Intervention/image
[link-intervention-docs]: http://image.intervention.io/
