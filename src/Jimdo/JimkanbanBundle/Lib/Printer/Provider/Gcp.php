<?php
namespace  Jimdo\JimkanbanBundle\Lib\Printer\Provider;
use \Jimdo\JimkanbanBundle\Lib\Google\GCP\Client;

class Gcp implements ProviderInterface
{
    /**
     * @var \Jimdo\JimkanbanBundle\Lib\Google\GCP\Client
     */
    private $gcpClient;

    public function __construct(Client $gcpClient)
    {
        $this->gcpClient = $gcpClient;
    }

    /**
     * @return array
     */
    public function getPrinters()
    {
        return $this->gcpClient->getPrinterList();
    }
}
