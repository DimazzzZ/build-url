<?php
/**
 * Project: build-url
 * Date: 02.11.15
 * Time: 11:14
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license MIT
 * @link    http://screensider.com/
 */

namespace DimazzzZ\UrlBuilder\Schemes;

use DimazzzZ\UrlBuilder\Exception;
use DimazzzZ\UrlBuilder\Query;

/**
 * Class Http
 * @package DimazzzZ\Schemes
 */
class Http extends Generic
{
    /**
     * Build URL and return as a string
     * @return string
     * @throws Exception
     */
    public function build()
    {
        $params = ['query' => Query::join($this->getQuery()->getProperties())];

        // Scheme can be set by default
        $params['scheme'] = $this->getScheme() !== false ? $this->getScheme() : 'http';

        // Host must be provided
        if ($this->getHost() !== false) {
            $params['host'] = $this->getHost();
        } else {
            throw new Exception('No host provided');
        }

        // Port number is optional
        if ($this->getPort() !== false) {
            $params['port'] = $this->getPort();
        }

        // Set username
        if ($this->getUser() !== false) {
            $params['user'] = $this->getUser();
        }

        // Set user password
        if ($this->getPassword() !== false) {
            $params['pass'] = $this->getPassword();
        }

        // Path can be set by default
        $params['path'] = $this->getPath() !== false ? $this->getPath() : '/';

        return self::join($this->originalString, $params);
    }
}
