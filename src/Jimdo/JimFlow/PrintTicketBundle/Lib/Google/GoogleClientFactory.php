<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Google;


use Symfony\Bundle\FrameworkBundle\Routing\Router;

class GoogleClientFactory
{
    private $clientId;
    private $clientSecret;
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    private $router;

    public function __construct($clientId, $clientSecret, Router $router)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->router = $router;
    }

    public function createClient()
    {
        $oauthRedirectUrl = $this->router->generate('oauth_callback', array(), true);


        $googleConfig = new \Google_Config();
        $googleConfig->setClientId($this->clientId);
        $googleConfig->setClientSecret($this->clientSecret);
        $googleConfig->setAccessType('offline');
        $googleConfig->setRedirectUri($oauthRedirectUrl);
        $googleConfig->setApprovalPrompt('force');

        $googleClient = new \Google_Client($googleConfig);
        $googleClient->addScope('https://www.googleapis.com/auth/cloudprint');


        return $googleClient;
    }
}
