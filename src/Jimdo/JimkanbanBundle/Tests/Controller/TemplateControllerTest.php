<?php

namespace Jimdo\JimkanbanBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use \Symfony\Bundle\FrameworkBundle\Client;

class TemplateControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function itShouldShowButtonsRepresentingGooglePrinters()
    {
        $crawler = $this->request('GET', 'template/ticket.html');
        $this->assertEquals(1, $crawler->filter('div.button:contains("EPSON WP-4025 Series")')->count());
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
