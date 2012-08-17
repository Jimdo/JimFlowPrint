<?php
namespace  Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider\Gcp;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider\GcpWithoutDocs;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Google\GCP\Client;

class GcpProviderFactory
{

    const ENV_PROD = 'prod';

    /**
     * @var \Jimdo\PrintTicketBundle\Lib\Google\GCP\Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Show docs button for testing purpose in every env except production, we don't need it there
     * @param $env
     * @return Gcp|GcpWithoutDocs
     */
    public function get($env)
    {
        if ($env == self::ENV_PROD) {
            return new GcpWithoutDocs($this->client);
        }  else {
            return new Gcp($this->client);
        }
    }

}
