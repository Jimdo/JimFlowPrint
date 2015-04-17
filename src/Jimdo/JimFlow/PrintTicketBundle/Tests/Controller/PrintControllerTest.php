<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use \Symfony\Bundle\FrameworkBundle\Client;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Config;

class PrintControllerTest extends WebTestCase
{

    /**
     * @var Symfony\Bundle\FrameworkBundle\Test\Client
     */
    private $client;

    /**
     * @test
     */
    public function itShouldProvideConfiguredPrintersAsJson()
    {
        $printers = array(
            new Config(1, 'awesome-printer', true),
            new Config(2, 'foo', false),
        );

        $printerProvider = $this->getMock('Jimdo\Jimflow\PrintTicketBundle\Lib\Printer\Provider\Gcp', array(), array(), '', false);
        $printerProvider->expects($this->any())->method('getPrinters')->will($this->returnValue($printers));

        $this->client = static::createClient();
        $this->client->getContainer()->set('jimdo.printing.provider.gcp', $printerProvider);

        $this->client->request('GET', 'print/printer');
        $response = $this->client->getResponse();
        $printerFromApi = json_decode($response->getContent());

        $this->assertEquals('application/json', $response->headers->get('content-type'));
        $this->assertEquals('awesome-printer', $printerFromApi[0]->name);
        $this->assertEquals(false, $printerFromApi[1]->isAvailable);
    }

}
