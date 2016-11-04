<?php
/**
 * Project: build-url
 * Date: 04.11.16
 * Time: 2:17
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license MIT
 * @link    http://screensider.com/
 */

use DimazzzZ\Url\Query;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetQueryValue()
    {
        $query = new Query('foo=bar&baz=qux');
        $this->assertEquals('bar', $query->get('foo'));
        $this->assertEquals('qux', $query->get('baz'));
    }

    public function testSetQueryValue()
    {
        $query = new Query('foo=bar&baz=qux');
        $query->add('key', 'value');
        $this->assertEquals('bar', $query->get('foo'));
        $this->assertEquals('qux', $query->get('baz'));
        $this->assertEquals('value', $query->get('key'));
    }
}
