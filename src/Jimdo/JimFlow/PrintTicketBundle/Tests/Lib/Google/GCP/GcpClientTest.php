<?php

use \Jimdo\JimFlow\PrintTicketBundle\Lib\Google\GCP\Client as GcpClient;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Google\Client;

class GcpClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Jimdo\PrintTicketBundle\Lib\Google\Client
     */
    private $client;

    public function setUp()
    {
        $this->client = $this->getMock('\Jimdo\JimFlow\PrintTicketBundle\Lib\Google\Client', array(), array(), '', false);
    }

    /**
     * @test
     */
    public function itShouldOnlyReturnTheListOfPrinters()
    {
        $printers = array('id' => 1);
        $data = array(
            'unimportantStuff' => 1,
            'printers' => $printers,
            'success' => true
        );

        $response = $this->getMock('\Buzz\Message\Response', array(), array(), '', false);
        $response->expects($this->any())->method('getContent')->will($this->returnValue(json_encode($data)));
        $response->expects($this->once())->method('isSuccessful')->will($this->returnValue(true));

        $this->client->expects($this->once())->method('get')->with('http://www.google.com/cloudprint/search')->will($this->returnValue($response));

        $gcpClient = new GcpClient($this->client);

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

        $gcpClient = new GcpClient($this->client);
        $gcpClient->getPrinterList();
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function itShouldThrowAnExceptionIfRequestIsStatus200ButUnsuccessfulAnyways()
    {
        $response = $this->getMock('\Buzz\Message\Response', array(), array(), '', false);
        $response->expects($this->once())->method('isSuccessful')->will($this->returnValue(true));
        $response->expects($this->any())->method('getContent')->will($this->returnValue(json_encode(array('success' => "false"))));

        $this->client->expects($this->once())->method('get')->with('http://www.google.com/cloudprint/search')->will($this->returnValue($response));

        $gcpClient = new GcpClient($this->client);
        $gcpClient->getPrinterList();
    }
}
