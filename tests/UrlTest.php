<?php
/**
 * Project: build-url
 * Date: 04.11.16
 * Time: 2:17
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license MIT
 * @link    http://screensider.com/
 */

use DimazzzZ\Url;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAnchorEmpty()
    {
        $url = new Url;
        $this->assertFalse($url->getAnchor());
    }

    public function testGetHostEmpty()
    {
        $url = new Url;
        $this->assertFalse($url->getHost());
    }

    public function testGetPasswordEmpty()
    {
        $url = new Url;
        $this->assertFalse($url->getPassword());
    }

    public function testGetPathEmpty()
    {
        $url = new Url;
        $this->assertFalse($url->getPath());
    }

    public function testGetPortEmpty()
    {
        $url = new Url;
        $this->assertFalse($url->getPort());
    }

    public function testGetQueryEmpty()
    {
        $url = new Url;
        $this->assertInstanceOf('DimazzzZ\Url\Query', $url->getQuery());
    }

    public function testGetSchemeEmpty()
    {
        $url = new Url;
        $this->assertFalse($url->getScheme());
    }

    public function testGetUserEmpty()
    {
        $url = new Url;
        $this->assertFalse($url->getUser());
    }

    public function testSetAnchor()
    {
        $url = new Url;
        $result = $url->setAnchor('anchorName');
        $this->assertInstanceOf('DimazzzZ\Url', $result);
        $this->assertEquals('anchorName', $url->getAnchor());
    }

    public function testSetHost()
    {
        $url = new Url;
        $result = $url->setHost('example.com');
        $this->assertInstanceOf('DimazzzZ\Url', $result);
        $this->assertEquals('example.com', $url->getHost());
    }

    public function testSetPassword()
    {
        $url = new Url;
        $result = $url->setPassword('secret');
        $this->assertInstanceOf('DimazzzZ\Url', $result);
        $this->assertEquals('secret', $url->getPassword());
    }

    public function testSetPath()
    {
        $url = new Url;
        $result = $url->setPath('/a/b/c');
        $this->assertInstanceOf('DimazzzZ\Url', $result);
        $this->assertEquals('/a/b/c', $url->getPath());
    }

    public function testSetPort()
    {
        $url = new Url;
        $result = $url->setPort(443);
        $this->assertInstanceOf('DimazzzZ\Url', $result);
        $this->assertEquals(443, $url->getPort());
    }

    public function testSetQuery()
    {
        $url = new Url;
        $result = $url->setQuery('key', 'value');
        $this->assertInstanceOf('DimazzzZ\Url', $result);
        $this->assertInstanceOf('DimazzzZ\Url\Query', $url->getQuery());
        $this->assertEquals('value', $url->getQuery()->get('key'));
        $url->setQuery(['foo' => 'bar', 'baz' => 'qux']);
        $this->assertInstanceOf('DimazzzZ\Url\Query', $url->getQuery());
        $this->assertEquals('bar', $url->getQuery()->get('foo'));
        $this->assertEquals('qux', $url->getQuery()->get('baz'));
    }

    public function testSetScheme()
    {
        $url = new Url;
        $result = $url->setScheme('http');
        $this->assertInstanceOf('DimazzzZ\Url', $result);
        $this->assertEquals('http', $url->getScheme());
        $result = $url->setScheme('https');
        $this->assertInstanceOf('DimazzzZ\Url', $result);
        $this->assertEquals('https', $url->getScheme());
        $result = $url->setScheme('ftp');
        $this->assertInstanceOf('DimazzzZ\Url', $result);
        $this->assertEquals('ftp', $url->getScheme());
        $result = $url->setScheme('market');
        $this->assertInstanceOf('DimazzzZ\Url', $result);
        $this->assertEquals('market', $url->getScheme());
        $result = $url->setScheme('//');
        $this->assertInstanceOf('DimazzzZ\Url', $result);
        $this->assertEquals('//', $url->getScheme());
    }

    public function testSetUser()
    {
        $url = new Url;
        $result = $url->setUser('johndoe');
        $this->assertInstanceOf('DimazzzZ\Url', $result);
        $this->assertEquals('johndoe', $url->getUser());
    }

    public function testBuild()
    {
        $url = new Url('https://user:password@www.example.com:561/sub/dir/?key=value#anchor');
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
