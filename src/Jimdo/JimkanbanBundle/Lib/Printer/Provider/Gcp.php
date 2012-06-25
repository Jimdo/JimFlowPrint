<?php
namespace  Jimdo\JimkanbanBundle\Lib\Printer\Provider;
use \Jimdo\JimkanbanBundle\Lib\Google\GCP\GCPClient;


class Gcp implements ProviderInterface
{
    /**
     * @var \Jimdo\JimkanbanBundle\Lib\Google\GCP\GCPClient
     */
    private $gcpClient;

    public function __construct(GCPClient $gcpClient)
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
