<?php
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Google\Client;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Google\ClientAuthManagerWrapper;
use \Zend\Cache\Storage\Adapter\Filesystem;

class ClientAuthManagerWrapperTest extends \PHPUnit_Framework_TestCase
{
    const SOME_URL = 'http://google.com';
    const SOME_AUTH_TOKEN = 'DDAA__FF';
    const AUTH_TOKEN_HEADER = 'Update-Client-Auth';

    /**
     * @var array
     */
    private $someHeader = array('x-foo: 1');

    /**
     * @var array
     */
    private $someContent = array('a' => 'b');

    /**
     * @var \Jimdo\PrintTicketBundle\Lib\Google\Client
     */
    private $googleClient;

    /**
     * @var \Zend\Cache\Storage\Adapter\Filesystem
     */
    private $cache;

    /**
     * @var \Buzz\Message\Response
     */
    private $response;

    public function setUp()
    {
        $this->googleClient = $this->getMock('\Jimdo\JimFlow\PrintTicketBundle\Lib\Google\Client', array(), array(), '', false);
        $this->cache = $this->getMock('\Zend\Cache\Storage\Adapter\Filesystem', array(), array(), '', false);

        $this->response = $this->getMock(
            '\Buzz\Message\Response',
            array(),
            array(),
            '',
            false
        );
    }

    /**
     * @test
     */
    public function itShouldUseTheGoogleClientToPerformGetRequest()
    {
        $someUrl = self::SOME_URL;
        $someHeader = $this->someHeader;
        $googleClient = $this->googleClient;
        $googleClient
                ->expects($this->once())
                ->method('get')
                ->with($someUrl, $someHeader)
                ->will($this->returnValue($this->response));

        $clientWrapper = new ClientAuthManagerWrapper($googleClient, $this->cache);
        $clientWrapper->get($someUrl, $someHeader);
    }

    /**
     * @test
     */
    public function itShouldUseTheGoogleClientToPerformPostRequest()
    {
        $someUrl = self::SOME_URL;
        $someHeader = $this->someHeader;
        $someContent = $this->someContent;

        $googleClient = $this->googleClient;
        $googleClient
                ->expects($this->once())
                ->method('post')
                ->with($someUrl, $someHeader, $someContent)
                ->will($this->returnValue($this->response));

        $clientWrapper = new ClientAuthManagerWrapper($googleClient, $this->cache);
        $clientWrapper->post($someUrl, $someHeader, $someContent);
    }

    /**
     * @test
     */
    public function itShouldUpdateAuthCodeIfUpdateClientAuthHeaderIsPresent()
    {
        $someToken = self::SOME_AUTH_TOKEN;
        $headerName = self::AUTH_TOKEN_HEADER;

        $response = $this->response;

        $response
                ->expects($this->any())
                ->method('getHeader')
                ->with($this->equalTo($headerName))
                ->will($this->returnValue($someToken));

        $googleClient = $this->getMock(
            '\Jimdo\JimFlow\PrintTicketBundle\Lib\Google\Client',
            array('get', 'setAuthToken'),
            array(),
            '',
            false
        );
        $googleClient
                ->expects($this->once())
                ->method('get')
                ->will($this->returnValue($response));

        $googleClient
                ->expects($this->at(2))
                ->method('setAuthToken')
                ->with($someToken);

        $clientWrapper = new ClientAuthManagerWrapper($googleClient, $this->cache);
        $clientWrapper->get('');
    }

    /**
     * @test
     */
    public function itShouldSaveTheAuthTokenToCacheIfNewOneIsProvided()
    {
        $someToken = self::SOME_AUTH_TOKEN;
        $headerName = self::AUTH_TOKEN_HEADER;

        $response = $this->response;

        $response
                ->expects($this->any())
                ->method('getHeader')
                ->with($this->equalTo($headerName))
                ->will($this->returnValue($someToken));

        $googleClient = $this->getMock(
            '\Jimdo\JimFlow\PrintTicketBundle\Lib\Google\Client',
            array('get', 'setAuthToken'),
            array(),
            '',
            false
        );
        $googleClient
                ->expects($this->once())
                ->method('get')
                ->will($this->returnValue($response));

        $cache = $this->cache;
        $cache->expects($this->once())->method('setItem');

        $clientWrapper = new ClientAuthManagerWrapper($googleClient, $cache);
        $clientWrapper->get('');
    }

    /**
     * @test
     */
    public function itShouldNotSaveTheAuthTokenToCacheIfThereIsNoNewOne()
    {
        $someToken = self::SOME_AUTH_TOKEN;
        $headerName = self::AUTH_TOKEN_HEADER;

        $response = $this->response;

        $response
                ->expects($this->any())
                ->method('getHeader')
                ->with($this->equalTo($headerName))
                ->will($this->returnValue(''));

        $googleClient = $this->getMock(
            '\Jimdo\JimFlow\PrintTicketBundle\Lib\Google\Client',
            array('get', 'setAuthToken'),
            array(),
            '',
            false
        );
        $googleClient
                ->expects($this->once())
                ->method('get')
                ->will($this->returnValue($response));

        $cache = $this->cache;
        $cache->expects($this->never())->method('setItem');

        $clientWrapper = new ClientAuthManagerWrapper($googleClient, $cache);
        $clientWrapper->get('');
    }

}
