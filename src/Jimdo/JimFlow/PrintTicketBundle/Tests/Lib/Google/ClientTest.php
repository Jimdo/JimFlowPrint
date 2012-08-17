<?php
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Google\GCP\Client as GcpClient;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Google\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{

    private $httpClient;
    private $gcpClient;

    public function setUp()
    {
        $this->httpClient = $this->getMock('\Buzz\Browser', array(), array(), '', false);
    }

    /**
     * @test
     */
    public function itShouldUseHttpClientToObtainAuthToken()
    {
        $response = $this->getMock('\Buzz\Message\Response', array(), array(), '', false);
        $response->expects($this->once())->method('getContent')->will($this->returnValue('Auth=dd'));

        $this->httpClient->expects($this->once())->method('post')->with('https://www.google.com/accounts/ClientLogin')->will($this->returnValue($response));
        $client = new Client($this->httpClient, '', '', '');
        $client->get('http://examlple.com');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itShouldThrowAnInvalidArgumentExceptionIfNoAuthIsProvided()
    {
        $response = $this->getMock('\Buzz\Message\Response', array(), array(), '', false);
        $response->expects($this->once())->method('getContent')->will($this->returnValue('NoAuthForYou'));

        $this->httpClient->expects($this->once())->method('post')->with('https://www.google.com/accounts/ClientLogin')->will($this->returnValue($response));
        $client = new Client($this->httpClient, '', '', '');
        $client->get('http://examlple.com');
    }

    /**
     * @test
     */
    public function itShouldAddGoogleAuthenticationCodeToFurtherRequests()
    {
        $url = 'http://example.com';
        $header = array('x-test: 1');
        $authCode = '123';
        $response = $this->getMock('\Buzz\Message\Response', array(), array(), '', false);
        $response->expects($this->once())->method('getContent')->will($this->returnValue('Auth=' . $authCode));

        $this->httpClient->expects($this->once())->method('post')->with('https://www.google.com/accounts/ClientLogin')->will($this->returnValue($response));
        $this->httpClient->expects($this->once())->method('get')->with($url, array_merge($header, array('Authorization: GoogleLogin Auth=' . $authCode)));

        $client = new Client($this->httpClient, '', '', '');
        $client->get($url, $header);
    }

    /**
     * @test
     */
    public function itShouldUseHttpClientToPerformGetRequestWithGivenUrlAndHeaders()
    {
        $url = 'http://google.com';
        $headers = array('x-awkward: 1');

        $this->httpClient->expects($this->once())->method('get')->with($url, $this->contains($headers[0]));

        $client = $this->getMock('\Jimdo\JimFlow\PrintTicketBundle\Lib\Google\Client', array('isAuthorized'), array($this->httpClient, '', '', ''));
        $client->expects($this->once())->method('isAuthorized')->will($this->returnValue(true));
        $client->get($url, $headers);
    }

    /**
     * @test
     */
    public function itShouldUseHttpClientToPerformPostRequestWithGivenUrlHeadersAndBody()
    {
        $url = 'http://google.com';
        $headers = array('x-awkward: 1');
        $content = array('foo' => 'bar');

        $this->httpClient->expects($this->once())->method('post')->with($url, $this->contains($headers[0]), $content);

        $client = $this->getMock('\Jimdo\JimFlow\PrintTicketBundle\Lib\Google\Client', array('isAuthorized'), array($this->httpClient, '', '', ''));
        $client->expects($this->once())->method('isAuthorized')->will($this->returnValue(true));
        $client->post($url, $headers, $content);
    }

    /**
     * @test
     */
    public function itShouldAllowToSetTheAuthToken()
    {
        $someToken = 'ABCLOLOL';
        $client = new Client($this->httpClient, '', '', '');
        $client->setAuthToken($someToken);

        $this->assertEquals($someToken, $client->getAuthToken());
    }

}
