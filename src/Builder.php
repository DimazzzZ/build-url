<?php
/**
 * Project: build-url
 * Date: 02.11.15
 * Time: 11:14
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license MIT
 * @link    http://screensider.com/
 */

namespace DimazzzZ\UrlBuilder;

use DimazzzZ\UrlBuilder\Schemes\Http;
use DimazzzZ\UrlBuilder\Schemes\SchemeInterface;

/**
 * Class Url
 * @package DimazzzZ
 */
class Builder
{
    /**
     * @var SchemeInterface
     */
    private $scheme;

    /**
     * Url constructor
     * @param string $url
     * @param string $scheme
     */
    public function __construct($url = null, $scheme = Http::class)
    {
        $this->scheme = new $scheme($url);
    }

    /**
     * @return string
     */
    public function build()
    {
        return $this->scheme->build();
    }
}
