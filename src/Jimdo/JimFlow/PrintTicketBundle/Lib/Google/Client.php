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

class Client implements ClientInterface
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


    private function requestWithAccessToken($method, $url, $content = null)
    {
        $accessToken = $this->accessTokenHandler->retrieveAccessToken();

        $headers = array(
            'Authorization' => 'Bearer ' . $accessToken
        );

        switch ($method) {
            case 'GET':
                return $this->httpClient->get($url, $headers);
            case 'POST':
                return $this->httpClient->post($url, $headers, $content);
            default:
                throw new \InvalidArgumentException($method . ' is no valid request type');
        }
    }

    /**
     * @param $url
     * @param array $headers
     * @return mixed
     */
    public function get($url, $headers = array())
    {

        $response = $this->requestWithAccessToken('GET' , $url);

        if ($response->getStatusCode() != 403) {
            return $response;
        }

        // access token probably expired
        // refresh and try again once
        $this->accessTokenHandler->refreshAccessToken();
        return $this->requestWithAccessToken('GET' , $url);
    }

    /**
     * @param $url
     * @param array $headers
     * @param $content
     * @return mixed
     */
    public function post($url, $headers = array(), $content)
    {
        $response = $this->requestWithAccessToken('POST', $url, $content);

        if ($response->getStatusCode() != 403) {
            return $response;
        }

        // access token probably expired
        // refresh and try again once
        $this->accessTokenHandler->refreshAccessToken();
        return $this->requestWithAccessToken('POST', $url, $content);
    }
}
