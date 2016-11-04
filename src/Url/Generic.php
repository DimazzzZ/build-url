<?php
/**
 * Project: build-url
 * Date: 02.11.15
 * Time: 11:49
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license MIT
 * @link    http://screensider.com/
 */

namespace DimazzzZ\Url;

/**
 * Class Generic
 * @package DimazzzZ\Url
 */
abstract class Generic
{
    /**
     * Original query string
     * @var string
     */
    protected $originalString;

    /**
     * Parsed string
     * @var array
     */
    protected $parsed = [];

    /**
     * Get query
     * @param $name
     * @return bool|string
     */
    public function getProperty($name)
    {
        if ($this->propertyExist($name)) {
            return $this->parsed[$name];
        }

        return false;
    }

    /**
     * Set property
     * @param string $name  Property name
     * @param string $value Property value
     */
    protected function setProperty($name, $value)
    {
        $this->parsed[$name] = $value;
    }

    /**
     * Get all properties as array
     * @return array
     */
    public function getProperties()
    {
        return $this->parsed;
    }

    /**
     * Check param exist
     * @param $name
     * @return bool
     */
    public function propertyExist($name)
    {
        return isset($this->parsed[$name]) ? true : false;
    }

    /**
     * Return original string
     * @return string
     */
    public function getOriginalString()
    {
        return $this->originalString;
    }
}
