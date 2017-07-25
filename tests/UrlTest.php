<?php
/**
 * Project: build-url
 * Date: 04.11.16
 * Time: 2:17
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license MIT
 * @link    http://screensider.com/
 */

use DimazzzZ\Http;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAnchorEmpty()
    {
        $url = new Http;
        $this->assertFalse($url->getAnchor());
    }

    public function testGetHostEmpty()
    {
        $url = new Http;
        $this->assertFalse($url->getHost());
    }

    public function testGetPasswordEmpty()
    {
        $url = new Http;
        $this->assertFalse($url->getPassword());
    }

    public function testGetPathEmpty()
    {
        $url = new Http;
        $this->assertFalse($url->getPath());
    }

    public function testGetPortEmpty()
    {
        $url = new Http;
        $this->assertFalse($url->getPort());
    }

    public function testGetQueryEmpty()
    {
        $url = new Http;
        $this->assertInstanceOf('DimazzzZ\Url\Query', $url->getQuery());
    }

    public function testGetSchemeEmpty()
    {
        $url = new Http;
        $this->assertFalse($url->getScheme());
    }

    public function testGetUserEmpty()
    {
        $url = new Http;
        $this->assertFalse($url->getUser());
    }

    public function testSetAnchor()
    {
        $url = new Http;
        $result = $url->setAnchor('anchorName');
        $this->assertInstanceOf('DimazzzZ\Http', $result);
        $this->assertEquals('anchorName', $url->getAnchor());
    }

    public function testSetHost()
    {
        $url = new Http;
        $result = $url->setHost('example.com');
        $this->assertInstanceOf('DimazzzZ\Http', $result);
        $this->assertEquals('example.com', $url->getHost());
    }

    public function testSetPassword()
    {
        $url = new Http;
        $result = $url->setPassword('secret');
        $this->assertInstanceOf('DimazzzZ\Http', $result);
        $this->assertEquals('secret', $url->getPassword());
    }

    public function testSetPath()
    {
        $url = new Http;
        $result = $url->setPath('/a/b/c');
        $this->assertInstanceOf('DimazzzZ\Http', $result);
        $this->assertEquals('/a/b/c', $url->getPath());
    }

    public function testSetPort()
    {
        $url = new Http;
        $result = $url->setPort(443);
        $this->assertInstanceOf('DimazzzZ\Http', $result);
        $this->assertEquals(443, $url->getPort());
    }

    public function testSetQuery()
    {
        $url = new Http;
        $result = $url->setQuery('key', 'value');
        $this->assertInstanceOf('DimazzzZ\Http', $result);
        $this->assertInstanceOf('DimazzzZ\Url\Query', $url->getQuery());
        $this->assertEquals('value', $url->getQuery()->get('key'));
        $url->setQuery(['foo' => 'bar', 'baz' => 'qux']);
        $this->assertInstanceOf('DimazzzZ\Url\Query', $url->getQuery());
        $this->assertEquals('bar', $url->getQuery()->get('foo'));
        $this->assertEquals('qux', $url->getQuery()->get('baz'));
    }

    public function testSetScheme()
    {
        $url = new Http;
        $result = $url->setScheme('http');
        $this->assertInstanceOf('DimazzzZ\Http', $result);
        $this->assertEquals('http', $url->getScheme());
        $result = $url->setScheme('https');
        $this->assertInstanceOf('DimazzzZ\Http', $result);
        $this->assertEquals('https', $url->getScheme());
        $result = $url->setScheme('ftp');
        $this->assertInstanceOf('DimazzzZ\Http', $result);
        $this->assertEquals('ftp', $url->getScheme());
        $result = $url->setScheme('market');
        $this->assertInstanceOf('DimazzzZ\Http', $result);
        $this->assertEquals('market', $url->getScheme());
        $result = $url->setScheme('//');
        $this->assertInstanceOf('DimazzzZ\Http', $result);
        $this->assertEquals('//', $url->getScheme());
    }

    public function testSetUser()
    {
        $url = new Http;
        $result = $url->setUser('johndoe');
        $this->assertInstanceOf('DimazzzZ\Http', $result);
        $this->assertEquals('johndoe', $url->getUser());
    }

    public function testBuild()
    {
        $url = new Http('https://user:password@www.example.com:561/sub/dir/?key=value#anchor');
        $this->assertEquals('anchor', $url->getAnchor());
        $this->assertEquals('www.example.com', $url->getHost());
        $this->assertEquals('password', $url->getPassword());
        $this->assertEquals('/sub/dir/', $url->getPath());
        $this->assertEquals(561, $url->getPort());
        $this->assertEquals('value', $url->getQuery()->get('key'));
        $this->assertEquals('https', $url->getScheme());
        $this->assertEquals('user', $url->getUser());
        $this->assertEquals('https://user:password@www.example.com:561/sub/dir/?key=value#anchor', $url->build());
    }
}
