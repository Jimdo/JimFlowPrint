<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Google;
use \Buzz\Browser;

class Client implements ClientInterface
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
     * @var string
     */
    private $serviceName;

    /**
     * @param Browser $httpClient
     * @param $email
     * @param $password
     * @param $serviceName
     */
    public function __construct(Browser $httpClient, $email, $password, $serviceName)
    {
        $this->httpClient = $httpClient;
        $this->email = $email;
        $this->password = $password;
        $this->serviceName = $serviceName;
    }

    /**
     * @param $url
     * @param array $headers
     * @param $content
     * @return \Buzz\Message\Response
     */
    public function post($url, $headers = array(), $content)
    {
        return $this->doRequest('POST', $url, $headers, $content);
    }

    /**
     * @param $url
     * @param  array                  $headers
     * @return \Buzz\Message\Response
     */
    public function get($url, $headers = array())
    {
        return $this->doRequest('GET', $url, $headers);
    }

    /**
     * @throws \InvalidArgumentException
     * @param $type
     * @param $url
     * @param  array                  $headers
     * @param  null                   $content
     * @return \Buzz\Message\Response
     */
    private function doRequest($type, $url, $headers = array(), $content = null)
    {
        $this->authorize();
        $headers = array_merge($headers, array('Authorization: GoogleLogin Auth=' . $this->authToken));

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
    public function isAuthorized()
    {
        return null != $this->authToken;
    }

    /**
     * @param $authToken
     * @return void
     */
    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;
    }

    /**
     * @return string
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @throws \InvalidArgumentException
     * @return void
     */
    private function authorize()
    {
        if (!$this->isAuthorized()) {
            $response = $this->requestAuthToken();

            preg_match('/Auth=(\S+)/', $response->getContent(), $authToken);

            if (!isset($authToken[1])) {
                throw new \InvalidArgumentException('Google does not want to let you in. Check your Credentials');
            }

            $this->authToken = $authToken[1];
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

    /**
     * @return string
     */
    private function getSource()
    {
        return 'JimKanban';
    }

    /**
     * @return string
     */
    private function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * @return string
     */
    private function getAccountType()
    {
        return 'Google';
    }
}
