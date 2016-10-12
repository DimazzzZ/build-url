<?php
/**
 * Project: build-url
 * Date: 02.11.15
 * Time: 11:14
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license MIT
 * @link    http://screensider.com/
 */

namespace DimazzzZ;

use DimazzzZ\Url\Exception;
use DimazzzZ\Url\Query;

/**
 * Class Url
 * @package DimazzzZ
 */
class Url extends Url\Generic
{
    const HTTP_URL_REPLACE        = 1;    // Replace every part of the first URL when there's one of the second URL
    const HTTP_URL_JOIN_PATH      = 2;    // Join relative paths
    const HTTP_URL_JOIN_QUERY     = 4;    // Join query strings
    const HTTP_URL_STRIP_USER     = 8;    // Strip any user authentication information
    const HTTP_URL_STRIP_PASS     = 16;   // Strip any password authentication information
    const HTTP_URL_STRIP_AUTH     = 32;   // Strip any authentication information
    const HTTP_URL_STRIP_PORT     = 64;   // Strip explicit port numbers
    const HTTP_URL_STRIP_PATH     = 128;  // Strip complete path
    const HTTP_URL_STRIP_QUERY    = 256;  // Strip query string
    const HTTP_URL_STRIP_FRAGMENT = 512;  // Strip any fragments (#identifier)
    const HTTP_URL_STRIP_ALL      = 1024; // Strip anything but scheme and host

    /**
     * @var Query
     */
    protected $parsedQuery;

    /**
     * Url constructor
     * @param string|null $url
     */
    public function __construct($url = null)
    {
        $this->originalString = $url;
        $this->parsed         = ($url === null) ? [] : parse_url($url);

        $query             = $this->getProperty('query');
        $this->parsedQuery = new Query($query);
    }

    /**
     * Get scheme e.g. http
     * @return bool|string
     */
    public function getScheme()
    {
        return $this->getProperty('scheme');
    }

    /**
     * Set scheme name (http, https, market, ftp etc.)
     * @param string $value Value
     */
    public function setScheme($value)
    {
        $this->setProperty('scheme', $value);
    }

    /**
     * Get host e.g. domain.com
     * @return bool|string
     */
    public function getHost()
    {
        return $this->getProperty('host');
    }

    /**
     * Set host (domain) name
     * @param string $value Value
     */
    public function setHost($value)
    {
        $this->setProperty('host', $value);
    }

    /**
     * Get port e.g. 22
     * @return bool|int
     */
    public function getPort()
    {
        return $this->getProperty('port');
    }

    /**
     * Set port
     * @param string $value Value
     */
    public function setPort($value)
    {
        $this->setProperty('port', $value);
    }

    /**
     * Get username
     * @return bool|string
     */
    public function getUser()
    {
        return $this->getProperty('user');
    }

    /**
     * Set user name
     * @param string $value Value
     */
    public function setUser($value)
    {
        $this->setProperty('user', $value);
    }

    /**
     * Get password
     * @return bool|string
     */
    public function getPassword()
    {
        return $this->getProperty('pass');
    }

    /**
     * Set password
     * @param string $value Value
     */
    public function setPassword($value)
    {
        $this->setProperty('pass', $value);
    }

    /**
     * Get path e.g. /path/to/something
     * @return bool|string
     */
    public function getPath()
    {
        return $this->getProperty('path');
    }

    /**
     * Set path
     * @param string $value Value
     */
    public function setPath($value)
    {
        $this->setProperty('path', $value);
    }

    /**
     * Get query string
     * @return bool|Query
     */
    public function getQuery()
    {
        return $this->parsedQuery;
    }

    /**
     * Set query key-value
     * @param string|array $key Key name or an array of key-value pairs
     * @param string|null  $value
     */
    public function setQuery($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->getQuery()->add($k, $v);
            }
        } else {
            $this->getQuery()->add($key, $value);
        }
    }

    /**
     * Get anchor by #
     * @return bool|string
     */
    public function getAnchor()
    {
        return $this->getProperty('fragment');
    }

    /**
     * Set anchor
     * @param string $value Value
     */
    public function setAnchor($value)
    {
        $this->setProperty('fragment', $value);
    }

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

    /**
     * Return object as a string
     * @return string
     * @throws Exception
     */
    public function __toString()
    {
        return $this->build();
    }

    /**
     * Build a URL (join all parameters together in one string)
     * @param string  $url     (part(s) of) an URL in form of a string or associative array like parse_url() returns
     * @param array   $parts   Same as the first argument
     * @param integer $flags   A bitmask of binary or'ed HTTP_URL constants; HTTP_URL_REPLACE is the default
     * @param bool    $new_url If set, it'll be filled with the parts of the composed url like parse_url() would return
     * @return string Returns the new URL as string on success or FALSE on failure.
     * @link https://gist.github.com/cincodenada/1126468 Original source code
     */
    public static function join($url, $parts = [], $flags = self::HTTP_URL_REPLACE, &$new_url = false)
    {
        $keys = [
            'user',
            'pass',
            'port',
            'path',
            'query',
            'fragment'
        ];

        // HTTP_URL_STRIP_ALL becomes all the HTTP_URL_STRIP_Xs
        if ($flags & self::HTTP_URL_STRIP_ALL) {
            $flags |= self::HTTP_URL_STRIP_USER;
            $flags |= self::HTTP_URL_STRIP_PASS;
            $flags |= self::HTTP_URL_STRIP_PORT;
            $flags |= self::HTTP_URL_STRIP_PATH;
            $flags |= self::HTTP_URL_STRIP_QUERY;
            $flags |= self::HTTP_URL_STRIP_FRAGMENT;
        } // HTTP_URL_STRIP_AUTH becomes HTTP_URL_STRIP_USER and HTTP_URL_STRIP_PASS
        else {
            if ($flags & self::HTTP_URL_STRIP_AUTH) {
                $flags |= self::HTTP_URL_STRIP_USER;
                $flags |= self::HTTP_URL_STRIP_PASS;
            }
        }

        // Parse the original URL
        $parse_url = parse_url($url);

        // Scheme and Host are always replaced
        if (isset($parts['scheme'])) {
            $parse_url['scheme'] = $parts['scheme'];
        }
        if (isset($parts['host'])) {
            $parse_url['host'] = $parts['host'];
        }

        // (If applicable) Replace the original URL with it's new parts
        if ($flags & self::HTTP_URL_REPLACE) {
            foreach ($keys as $key) {
                if (isset($parts[$key])) {
                    $parse_url[$key] = $parts[$key];
                }
            }
        } else {
            // Join the original URL path with the new path
            if (isset($parts['path']) && ($flags & self::HTTP_URL_JOIN_PATH)) {
                if (isset($parse_url['path'])) {
                    $parse_url['path'] = rtrim(
                            str_replace(basename($parse_url['path']), '', $parse_url['path']), '/'
                        ) . '/' . ltrim($parts['path'], '/');
                } else {
                    $parse_url['path'] = $parts['path'];
                }
            }

            // Join the original query string with the new query string
            if (isset($parts['query']) && ($flags & self::HTTP_URL_JOIN_QUERY)) {
                if (isset($parse_url['query'])) {
                    $parse_url['query'] .= '&' . $parts['query'];
                } else {
                    $parse_url['query'] = $parts['query'];
                }
            }
        }

        // Strips all the applicable sections of the URL
        // Note: Scheme and Host are never stripped
        foreach ($keys as $key) {
            if ($flags & (int)constant('self::HTTP_URL_STRIP_' . strtoupper($key))) {
                unset($parse_url[$key]);
            }
        }


        $new_url = $parse_url;

        $scheme = '';

        if (isset($parse_url['scheme'])) {
            switch ($parse_url['scheme']) {
                case '//':
                    $scheme = '//';
                    break;
                default:
                    $scheme = $parse_url['scheme'] . '://';
                    break;
            }
        }

        return $scheme . ((isset($parse_url['user'])) ? $parse_url['user'] . ((isset($parse_url['pass'])) ? ':' . $parse_url['pass'] : '') . '@' : '') . ((isset($parse_url['host'])) ? $parse_url['host'] : '') . ((isset($parse_url['port'])) ? ':' . $parse_url['port'] : '') . ((isset($parse_url['path'])) ? $parse_url['path'] : '') . ((isset($parse_url['query'])) ? '?' . $parse_url['query'] : '') . ((isset($parse_url['fragment'])) ? '#' . $parse_url['fragment'] : '');
    }
}
