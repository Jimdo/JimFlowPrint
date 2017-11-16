<?php

use Jimdo\JimFlow\PrintTicketBundle\Lib\Google\Client;
use Mockery as m;

class ClientTest extends \PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    /**
     * @test
     */
    public function itShouldRequestWithGivenUrlAndAccessToken()
    {
        $someAccessToken = 'srdsf';
        $someUrl = 'http://example.org';

        $expectedHeaders = array(
            'Authorization' => 'Bearer ' . $someAccessToken
        );

        $aSuccessfulResponse = $this->aSuccessfulResponse();

        $aHttpClient = $this->aHttpClient();

        $anAccessTokenHandler = $this->anAccessTokenHandler();
        $anAccessTokenHandler->shouldReceive('retrieveAccessToken')
            ->andReturn($someAccessToken);


        $aHttpClient->shouldReceive('get')
            ->with($someUrl, $expectedHeaders)
            ->andReturn($aSuccessfulResponse);


        $client = new Client($aHttpClient, $anAccessTokenHandler);

        $client->get($someUrl);

        $aHttpClient->shouldHaveReceived('get')
            ->with($someUrl, $expectedHeaders)
            ->once();
    }

    /**
     * @test
     */
    public function itShouldRefreshAccessTokenWhenRequestFailsWith403()
    {

        $someUrl = 'http://example.org';

        $a403Response = $this->aResponse();
        $a403Response->shouldReceive('getStatusCode')
            ->andReturn(403);

        $aHttpClient = $this->aHttpClient();

        $anAccessTokenHandler = $this->anAccessTokenHandler();
        $anAccessTokenHandler->shouldIgnoreMissing();

        $aHttpClient->shouldReceive('get')
            ->andReturn($a403Response);

        $client = new Client($aHttpClient, $anAccessTokenHandler);

        $client->get($someUrl);

        // assertion
        $anAccessTokenHandler->shouldHaveReceived('refreshAccessToken')
            ->once();
    }

    /**
     * @test
     */
    public function itShouldTryRequestAgainWhenWhenRequestFailsWith403()
    {

        $someUrl = 'http://example.org';

        $a403Response = $this->aResponse();
        $a403Response->shouldReceive('getStatusCode')
            ->andReturn(403);

        $aHttpClient = $this->aHttpClient();

        $anAccessTokenHandler = $this->anAccessTokenHandler();
        $anAccessTokenHandler->shouldIgnoreMissing();

        $aHttpClient->shouldReceive('get')
            ->andReturn($a403Response);

        $client = new Client($aHttpClient, $anAccessTokenHandler);

        $client->get($someUrl);

        // assertion
        $aHttpClient->shouldHaveReceived('get')
            ->twice();
    }

    /**
     * @test
     */
    public function itShouldPostUsingHttpClient()
    {

        $someUrl = 'http://example.org';
        $somePostBody = 'sdjklewjklfds';

        $aSuccessfulResponse = $this->aSuccessfulResponse();


        $anAccessTokenHandler = $this->anAccessTokenHandler();
        $anAccessTokenHandler->shouldIgnoreMissing();

        $aHttpClient = $this->aHttpClient();
        $aHttpClient->shouldReceive('post')
            ->andReturn($aSuccessfulResponse);

        $client = new Client($aHttpClient, $anAccessTokenHandler);

        $client->post($someUrl, array(), $somePostBody);

        // assertion
        $aHttpClient->shouldHaveReceived('post')
            ->once()
            ->with($someUrl, m::any() ,$somePostBody);
    }

    /**
     * @return m\MockInterface
     */
    private function aSuccessfulResponse()
    {
        $aSuccessfulResponse = $this->aResponse();
        $aSuccessfulResponse->shouldReceive('getStatusCode')
            ->andReturn(200);
        return $aSuccessfulResponse;
    }

    /**
     * @return m\MockInterface
     */
    private function aResponse()
    {
        $aSuccessfulResponse = m::mock('Buzz\Message\Response');
        return $aSuccessfulResponse;
    }

    /**
     * @return m\MockInterface
     */
    private function aHttpClient()
    {
        $httpClient = m::mock('Buzz\Browser');
        return $httpClient;
    }

    /**
     * @return m\MockInterface
     */
    private function anAccessTokenHandler()
    {
        $accessTokenHandler = m::mock('Jimdo\JimFlow\PrintTicketBundle\Lib\Google\AccessToken');
        return $accessTokenHandler;
    }
}
