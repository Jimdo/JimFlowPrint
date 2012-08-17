<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketTypeControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function returnsHttpStatusCodeOk()
    {
        $this->markTestSkipped();
        // Create a new client to browse the application
        $client = static::createClient();

        $client->request('GET', '/tickettype/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function editShouldShowAForm()
    {

    }

    /**
     * @test
     */
    public function editFormShouldPersistMyChangesOnSubmit()
    {

    }
}
