<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Google;


use Jimdo\JimFlow\PrintTicketBundle\Entity\GoogleAuthTokenRepository;
use Zend\Cache\Storage\Adapter\AbstractAdapter;

class AccessToken
{
    const CACHE_KEY = 'JIMDO_JIMFLOW_GOOGLE_ACCESS_TOKEN';
    /**
     * @var \Google_Client
     */
    private $googleClient;
    /**
     * @var AbstractAdapter
     */
    private $cache;
    /**
     * @var \Jimdo\JimFlow\PrintTicketBundle\Entity\GoogleAuthTokenRepository
     */
    private $googleAuthTokenRepository;

    public function __construct(\Google_Client $googleClient, AbstractAdapter $cache, GoogleAuthTokenRepository $googleAuthTokenRepository)
    {
        $this->googleClient = $googleClient;
        $this->cache = $cache;
        $this->googleAuthTokenRepository = $googleAuthTokenRepository;
    }

    public function retrieveAccessToken()
    {
        return $this->cache->getItem(self::CACHE_KEY);
    }

    public function refreshAccessToken()
    {
        $googleAuthToken = $this->googleAuthTokenRepository->findOneBy(array());
        $this->googleClient->refreshToken($googleAuthToken->getRefreshToken());
        $accessTokenData = $this->googleClient->getAccessToken();
        $accessToken = json_decode($accessTokenData);
        $accessToken = $accessToken->access_token;

        $this->cache->setItem(self::CACHE_KEY, $accessToken);
    }

}
