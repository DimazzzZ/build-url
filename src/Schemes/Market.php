<?php
/**
 * Project: build-url
 * Date: 25.07.17
 * Time: 18:01
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license MIT
 * @link    http://screensider.com/
 */

namespace DimazzzZ\UrlBuilder\Schemes;

use DimazzzZ\UrlBuilder\Exception;
use DimazzzZ\UrlBuilder\Query;

/**
 * Class Market
 * @package DimazzzZ\Schemes
 */
class Market extends Generic
{
    const SCHEME_NAME = 'market';

    /**
     * @see https://developer.android.com/distribute/marketing-tools/linking-to-google-play.html?hl=ru#UriSummary
     * @see https://www.iana.org/assignments/uri-schemes/prov/market
     * @var array
     */
    protected $urlMasks = [
        'store/apps/details'    => 'details',
        'store/apps/dev'        => 'dev',
        'store/search'          => 'search',
        'store/apps/collection' => 'apps',
    ];

    /**
     * @inheritdoc
     */
    public function getScheme()
    {
        return static::SCHEME_NAME;
    }

    /**
     * Build URL and return as a string
     * @return string
     * @throws Exception
     */
    public function build()
    {
        $path = $this->getPath() !== false ? $this->getPath() : 'details';

        foreach ($this->urlMasks as $urlMask => $value) {
            if (strpos($path, $urlMask) !== false) {
                if ($value == 'apps') {
                    $path = $value . '' . str_replace($urlMask, 'collection', $path);
                } else {
                    $path = $value;
                }
            }
        }

        $query = Query::join($this->getQuery()->getProperties());

        $url = $this->getScheme() . '://';
        $url .= $path;

        if (!empty($query)) {
            $url .= '?' . Query::join($this->getQuery()->getProperties());
        }

        return $url;
    }
}
