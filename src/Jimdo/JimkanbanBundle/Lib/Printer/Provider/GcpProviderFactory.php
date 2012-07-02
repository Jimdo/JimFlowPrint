<?php
namespace  Jimdo\JimkanbanBundle\Lib\Printer\Provider;
use Jimdo\JimkanbanBundle\Lib\Printer\Provider\Gcp;
use Jimdo\JimkanbanBundle\Lib\Printer\Provider\GcpWithoutDocs;
use Jimdo\JimkanbanBundle\Lib\Google\GCP\Client;

class GcpProviderFactory
{

    const ENV_PROD = 'prod';

    /**
     * @var \Jimdo\JimkanbanBundle\Lib\Google\GCP\Client
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
