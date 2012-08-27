<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use \Symfony\Bundle\FrameworkBundle\Client;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Config;

class TemplateControllerTest extends WebTestCase
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

        $printerProvider = $this->getMock('Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider\Gcp', array(), array(), '', false);
        $printerProvider->expects($this->any())->method('getPrinters')->will($this->returnValue($printers));

        $this->client = static::createClient();
        $this->client->getContainer()->set('jimdo.printing.provider.gcp', $printerProvider);;
    }

    /**
     * @test
     */
    public function itShouldShowButtonsRepresentingGooglePrintersInTicketView()
    {
        $crawler = $this->client->request('GET', 'template/ticket.html');
        $this->assertEquals(1, $crawler->filter('div.button:contains("awesome-printer")')->count());
    }

    /**
     * @test
     */
    public function itShouldShowButtonsRepresentingGooglePrintersInStoryView()
    {
        $crawler = $this->client->request('GET', 'template/story.html');
        $this->assertEquals(1, $crawler->filter('div.button:contains("awesome-printer")')->count());
    }

    /**
     * XXX As we do not have fixtures for now we do not provide ticket type here
     * @test
     */
    public function itShouldShowTheProvidedData()
    {
        $data = array(
            'reporter' => 'hans',
            'id' => 'T2445',
            'created' => '2012-06-24',
        );

        $crawler = $this->client->request('GET', 'template/ticket.html?' . http_build_query($data) . '&title=foo');

	$data['id'] = substr($data['id'], 1);

        foreach ($data as $key => $value) {
            $this->assertEquals(1, $crawler->filter('div.big-meta p:contains("' . $value . '")')->count(), $value);
        }

        $this->assertEquals(1, $crawler->filter('#text:contains("foo")')->count());
    }

    /**
     * @param  string                                $method
     * @param  string                                $url
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    private function request($method, $url)
    {
        $client = $this->httpClient();

        return $client->request($method, $url);
    }

    /**
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    private function httpClient()
    {
        return static::createClient();
    }
}
