<?php

namespace Jimdo\JimkanbanBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketTypeControllerTest extends WebTestCase
{
    public function testListStatusCode()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        $crawler = $client->request('GET', '/tickettype/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }
}