<?php
/**
 * Webiny Framework (http://www.webiny.com/framework)
 *
 * @copyright Copyright Webiny LTD
 */

namespace Webiny\Component\OAuth2\Tests;

use Webiny\Component\OAuth2\OAuth2;
use Webiny\Component\OAuth2\OAuth2Loader;
use Webiny\Component\OAuth2\OAuth2Request;


class OAuth2RequestTest extends \PHPUnit_Framework_TestCase
{
    const CONFIG = '/ExampleConfig.yaml';

    /**
     * @param $r OAuth2Request
     *
     * @dataProvider dataProvider
     */
    public function testConstructor($r)
    {
        $this->assertInstanceOf('\Webiny\Component\OAuth2\OAuth2Request', $r);
    }

    /**
     * @param $r OAuth2Request
     *
     * @dataProvider dataProvider
     */
    public function testSetUrl($r)
    {
        $r->setUrl('http://test-url.com/oauth2');
    }

    /**
     * @param $r OAuth2Request
     *
     * @dataProvider dataProvider
     */
    public function testGetUrl($r)
    {
        $r->setUrl('http://test-url.com/oauth2');
        $this->assertSame('http://test-url.com/oauth2', $r->getUrl());
    }

    /**
     * @param $r OAuth2Request
     *
     * @dataProvider dataProvider
     */
    public function testSetRequestTypeGet($r)
    {
        $r->setRequestType('get');
        $this->assertSame('GET', $r->getRequestType());
    }

    /**
     * @param $r OAuth2Request
     *
     * @dataProvider dataProvider
     */
    public function testSetRequestTypePost($r)
    {
        $r->setRequestType('post');
        $this->assertSame('POST', $r->getRequestType());
    }

    /**
     * @param $r OAuth2Request
     *
     * @dataProvider dataProvider
     * @expectedException \Webiny\Component\OAuth2\OAuth2Exception
     */
    public function testSetRequestTypeException($r)
    {
        $r->setRequestType('transport');
    }

    /**
     * @param $r OAuth2Request
     *
     * @dataProvider dataProvider
     */
    public function testSetParams($r)
    {
        $r->setParams([
                          'p1' => 'a',
                          'p2' => 'b'
                      ]
        );
    }

    /**
     * @param $r OAuth2Request
     *
     * @dataProvider dataProvider
     */
    public function testGetParams($r)
    {
        $params = [
            'p1' => 'a',
            'p2' => 'b'
        ];
        $r->setParams($params);

        $this->assertSame($params, $r->getParams());
    }

    /**
     * @param $r OAuth2Request
     *
     * @dataProvider dataProvider
     */
    public function testSetHeaders($r)
    {
        $r->setHeaders([
                           'h1' => 'a',
                           'h2' => 'b'
                       ]
        );
    }

    /**
     * @param $r OAuth2Request
     *
     * @dataProvider dataProvider
     */
    public function testGetHeaders($r)
    {
        $params = [
            'h1' => 'a',
            'h2' => 'b'
        ];
        $r->setHeaders($params);

        $this->assertSame($params, $r->getHeaders());
    }


    public function dataProvider()
    {
        OAuth2::setConfig(realpath(__DIR__ . '/' . self::CONFIG));

        // we need to mock the $_SERVER
        $_SERVER = [
            'USER'            => 'webiny',
            'HOME'            => '/home/webiny',
            'SCRIPT_FILENAME' => '/var/www/projects/webiny/Public/index.php',
            'SCRIPT_NAME'     => '/index.php',
            'REQUEST_URI'     => '/batman-is-better-than-superman/?batman=one&superman=two',
            'DOCUMENT_URI'    => '/index.php',
            'SERVER_PROTOCOL' => 'HTTP/1.1',
            'REMOTE_ADDR'     => '192.168.58.1',
            'SERVER_NAME'     => 'admin.w3.com',
        ];

        $oauth2Instance = OAuth2Loader::getInstance('Facebook');
        $oauth2Request = new OAuth2Request($oauth2Instance);

        return [
            [$oauth2Request]
        ];
    }
}