<?php

namespace Jimdo\JimkanbanBundle\Lib\Google;
use \Buzz\Browser;

abstract class GoogleClient
{
    const CLIENT_LOGIN_URL = 'https://www.google.com/accounts/ClientLogin';

     /**
     * @var \Buzz\Browser
     */
    private $httpClient;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $authToken;

    /**
     * @param \Buzz\Browser $httpClient
     * @param $email
     * @param $password
     */
    public function __construct(Browser $httpClient, $email, $password)
    {
        $this->httpClient = $httpClient;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @param $url
     * @param array $headers
     * @param $content
     * @return \Buzz\Message\Response
     */
    protected  function post($url, $headers = array(), $content)
    {
        return $this->doRequest('POST', $url, $headers, $content);
    }

    /**
     * @param $url
     * @param array $headers
     * @return \Buzz\Message\Response
     */
    protected function get($url, $headers = array())
    {
        return $this->doRequest('GET', $url, $headers);
    }

    /**
     * @throws \InvalidArgumentException
     * @param $type
     * @param $url
     * @param array $headers
     * @param null $content
     * @return \Buzz\Message\Response
     */
    private function doRequest($type, $url, $headers = array(), $content = null)
    {
        $this->authorize();
        $headers = array_merge($headers, array('Authorization: GoogleLogin ' . $this->authToken));
        switch ($type) {
        case 'GET':
            return $this->httpClient->get($url, $headers);
            case 'POST':
                return $this->httpClient->post($url, $headers, $content);
            default:
                throw new \InvalidArgumentException($type . ' is no valid request type');
        }

    }


    /**
     * @return bool
     */
    private function isAuthorized()
    {
        return null !== $this->authToken;
    }

    /**
     * @return void
     */
    private function authorize()
    {
        if (!$this->isAuthorized()) {
            $response = $this->requestAuthToken();

            preg_match('/Auth=\S+/', $response->getContent(), $authToken);
            //Todo exception
            $this->authToken = $authToken[0];
        }
    }

    /**
     * @return \Buzz\Message\Response
     */
    private function requestAuthToken()
    {
        $postData = array(
            'Email' => $this->email,
            'Passwd' => $this->password,
            'accountType' => $this->getAccountType(),
            'source' => $this->getSource(),
            'service' => $this->getServiceName()
        );

        return $this->httpClient->post(self::CLIENT_LOGIN_URL, array(), $postData);
    }

    protected abstract function getAccountType();
    protected abstract function getSource();
    protected abstract function getServiceName();

}