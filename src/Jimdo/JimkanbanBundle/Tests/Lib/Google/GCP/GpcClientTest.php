<?php

use \Jimdo\JimkanbanBundle\Lib\Google\GCP\GCPClient;
use \Jimdo\JimkanbanBundle\Lib\Google\GoogleClient;

class GpcClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Jimdo\JimkanbanBundle\Lib\Google\GoogleClient
     */
    private $client;

    public function setUp()
    {
        $this->client = $this->getMock('\Jimdo\JimkanbanBundle\Lib\Google\GoogleClient', array(), array(), '', false);
    }

    /**
     * @test
     */
    public function itShouldOnlyReturnTheListOfPrinters()
    {
        $printers = array('id' => 1);
        $data = array(
            'unimportantStuff' => 1,
            'printers' => $printers
        );

        $response = $this->getMock('\Buzz\Message\Response', array(), array(), '', false);
        $response->expects($this->once())->method('getContent')->will($this->returnValue(json_encode($data)));
        $response->expects($this->once())->method('isSuccessful')->will($this->returnValue(true));

        $this->client->expects($this->once())->method('get')->with('http://www.google.com/cloudprint/search')->will($this->returnValue($response));

        $gcpClient = new GCPClient($this->client);

        $this->assertEquals($printers, $gcpClient->getPrinterList());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itShouldThrowAnExceptionIfRequestIsNotSuccessful()
    {

        $response = $this->getMock('\Buzz\Message\Response', array(), array(), '', false);
        $response->expects($this->once())->method('isSuccessful')->will($this->returnValue(false));

        $this->client->expects($this->once())->method('get')->with('http://www.google.com/cloudprint/search')->will($this->returnValue($response));

        $gcpClient = new GCPClient($this->client);
        $gcpClient->getPrinterList();
    }
}
