<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use \Symfony\Bundle\FrameworkBundle\Client;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Config;

class PrintButtonsControllerTest extends WebTestCase
{

    /**
     * @var Symfony\Bundle\FrameworkBundle\Test\Client
     */
    private $client;

    public function setUp()
    {
        $printers = array(
            new Config(1, 'foo', true),
            new Config(2, 'awesome-printer', true),
        );

        $printerProvider = $this->getMock('Jimdo\Jimflow\PrintTicketBundle\Lib\Printer\Provider\Gcp', array(), array(), '', false);
        $printerProvider->expects($this->any())->method('getPrinters')->will($this->returnValue($printers));

        $this->client = static::createClient();
        $this->client->getContainer()->set('jimdo.printing.provider.gcp', $printerProvider);
    }

    /**
     * @test
     */
    public function itShouldShowButtonsRepresentingGooglePrintersInTicketView()
    {

        $crawler = $this->client->request('GET', 'buttons/iframe.html');

        $this->assertEquals(1, $crawler->filter('div.button:contains("awesome-printer")')->count());
    }

    /**
     * @test
     */
    public function itShouldBeJavascript()
    {
        $crawler = $this->client->request('GET', 'buttons/loader.js');

        $response = $this->client->getResponse();
        $this->assertEquals('application/javascript', $response->headers->get('content-type'));
    }
}
