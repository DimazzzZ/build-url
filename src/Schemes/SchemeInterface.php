<?php
/**
 * Project: build-url
 * Date: 25.07.17
 * Time: 17:47
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license MIT
 * @link    http://screensider.com/
 */

namespace DimazzzZ\UrlBuilder\Schemes;

interface SchemeInterface
{
    /**
     * Builds an URL string
     * @return string
     */
    public function build();
}
