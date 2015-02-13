<?php
/**
 * Created by IntelliJ IDEA.
 * User: robin
 * Date: 13.02.15
 * Time: 10:27
 */

namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Google;


use Buzz\Browser;
use Zend\Cache\Storage\Adapter\AbstractAdapter;

class NewClient implements ClientInterface
{

    /**
     * @var \Buzz\Browser
     */
    private $httpClient;
    /**
     * @var AccessToken
     */
    private $accessTokenHandler;

    public function __construct(Browser $httpClient, AccessToken $accessTokenHandler)
    {
        $this->httpClient = $httpClient;
        $this->accessTokenHandler = $accessTokenHandler;
    }

    private function getWithAccessToken($url)
    {
        return $this->requestWithAccessToken('get', $url);
    }
    private function postWithAccessToken($url)
    {
        return $this->requestWithAccessToken('post', $url);
    }
    private function requestWithAccessToken($method, $url)
    {
        $accessToken = $this->accessTokenHandler->retrieveAccessToken();

        $headers = array(
            'Authorization' => 'Bearer ' . $accessToken
        );
        return $this->httpClient->{$method}($url, $headers);
    }

    /**
     * @param $url
     * @param array $headers
     * @return mixed
     */
    public function get($url, $headers = array())
    {
        $response = $this->getWithAccessToken($url);

        if ($response->getStatusCode() != 403) {
            return $response;
        }

        // access token probably expired
        // refresh and try again once
        $this->accessTokenHandler->refreshAccessToken();
        return $this->getWithAccessToken($url);
    }

    /**
     * @param $url
     * @param array $headers
     * @param $content
     * @return mixed
     */
    public function post($url, $headers = array(), $content)
    {
        // TODO: Implement post() method.
    }
}
