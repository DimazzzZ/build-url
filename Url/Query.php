<?php
/**
 * Project: build-url
 * Date: 02.11.15
 * Time: 11:48
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license MIT
 * @link    http://screensider.com/
 */

namespace DimazzzZ\Url;

/**
 * Class Query
 * @package DimazzzZ\Url
 */
class Query extends Generic
{
    /**
     * Query constructor.
     * @param string $queryString
     */
    public function __construct($queryString)
    {
        $this->originalString = $queryString;
        $this->parseString($queryString);
    }

    /**
     * Parse query string
     * @param $string
     */
    private function parseString($string)
    {
        $pairs = explode('&', $string);
        $pairs = array_filter($pairs);

        foreach ($pairs as $pair) {
            @list($key, $value) = explode('=', $pair);
            $this->parsed[$key] = $value;
        }
    }

    /**
     * Get query parameter value
     * @param string $name parameter name
     * @return bool|string
     */
    public function get($name)
    {
        return $this->getProperty($name);
    }

    /**
     * Add new query key-value pair or replace old one
     * @param string $key   Key name
     * @param string $value Key value
     * @return $this
     */
    public function add($key, $value)
    {
        $this->parsed[$key] = $value;
        return $this;
    }

    /**
     * Get object as string
     * @return string
     */
    public function __toString()
    {
        return $this->originalString;
    }

    /**
     * Join URL query parameters
     * @param array $data   Key-value pair items
     * @param bool  $encode Encode with RFC or not
     * @return string
     */
    public static function join(array $data, $encode = false)
    {
        if ($encode) {
            return http_build_query($data);
        }

        $result = [];

        foreach ($data as $key => $value) {
            $result[] = $key . '=' . $value;
        }

        return implode('&', $result);
    }
}
