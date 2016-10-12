# OOP URL builder

Simple object oriented replacement for PHP's native _http_build_query_ and PECL's _http_build_url_

## Examples

```php
<?php

use DimazzzZ\Url;

// Build simple URL. just schema and host
$url = new Url;
$url->setHost('example.com');

echo $url; // http://example.com/
// or
echo $url->build(); // outputs the same

// Set another scheme
$url->setScheme('ftp');
echo $url; // outputs ftp://example.com/

// Set relative protocol
$url->setScheme('//');
echo $url; // outputs //example.com/

// Change path
$url->setPath('/sub/dir');
echo $url; // outputs //example.com/sub/dir/

// Add port
$url->setPort('443');
echo $url; // outputs //example.com:443/sub/dir/

// Add some query params
$url->setQuery(['a' => 'b', 'c' => 'd']);
echo $url; // outputs //example.com:443/sub/dir/?a=b&c=d

// ... and another one
$url->setQuery('param', 'value');
echo $url; // outputs //example.com:443/sub/dir/?a=b&c=d&param=value

// You can change just a part of your existing url
$url = new Url('http://example.com/?foo=bar');
$url->setHost('images.google.com');
echo $url; // outputs http://images.google.com/?foo=bar

```