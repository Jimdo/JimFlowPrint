<?php
use \Mockery as m;

class AccessTokenTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    /**
     * @test
     */
    public function itShouldWriteAccessTokenToCacheWhenRefreshing()
    {
        $accessToken = '345654';

        $googleClient = m::mock('\Google_Client');
        $googleClient->shouldIgnoreMissing();

        $googleClient->shouldReceive('getAccessToken')
            ->andReturn('{"access_token": "'. $accessToken. '"}');

        $cache = $this->getCache();

        $googleAuthToken = m::mock('Jimdo\JimFlow\PrintTicketBundle\Entity\GoogleAuthToken');
        $googleAuthToken->shouldIgnoreMissing();
        $googleAuthRepository = m::mock('Jimdo\JimFlow\PrintTicketBundle\Entity\GoogleAuthTokenRepository');

        $googleAuthRepository->shouldReceive('findOneBy')
            ->andReturn($googleAuthToken);


        $accessTokenHandler = new \Jimdo\JimFlow\PrintTicketBundle\Lib\Google\AccessToken($googleClient, $cache, $googleAuthRepository);
        $accessTokenHandler->refreshAccessToken();

        $cache->shouldHaveReceived('setItem')
            ->with(m::any(), $accessToken);
    }

    /**
     * @test
     * @expectedException Exception
     */
    public function itShouldThrowExceptionWhenThereIsNoRefreshTokenWhenRefreshingAndNotWriteToCache()
    {
        $googleClient = m::mock('\Google_Client');
        $googleClient->shouldIgnoreMissing();

        $cache = $this->getCache();
        $googleAuthRepository = m::mock('Jimdo\JimFlow\PrintTicketBundle\Entity\GoogleAuthTokenRepository');

        $googleAuthRepository->shouldReceive('findOneBy')
            ->andReturn(null);


        $accessTokenHandler = new \Jimdo\JimFlow\PrintTicketBundle\Lib\Google\AccessToken($googleClient, $cache, $googleAuthRepository);
        $accessTokenHandler->refreshAccessToken();
    }


    /**
     * @return m\MockInterface
     */
    private function getCache()
    {
        $cache = m::mock('Zend\Cache\Storage\Adapter\Filesystem');
        $cache->shouldDeferMissing();

        return $cache;
    }
}
